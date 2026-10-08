<?php

namespace Webkul\Myfatoorah\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Myfatoorah\Http\WebhookSignature;
use Webkul\Myfatoorah\Payment\Myfatoorah;
use Webkul\Sales\Contracts\Order as OrderContract;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shop\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected Myfatoorah $myfatoorah,
        protected CartRepository $cartRepository,
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
    ) {}

    /**
     * Create the MyFatoorah payment of the current cart and redirect to its hosted payment url.
     */
    public function redirect(): RedirectResponse
    {
        if (! $this->myfatoorah->hasValidCredentials()) {
            session()->flash('error', trans('my_fatoorah::app.response.provide-credentials'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $cart = Cart::getCart();

        if (! $cart) {
            session()->flash('error', trans('my_fatoorah::app.response.cart-not-found'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $data = $this->myfatoorah->createPayment(
            $cart,
            route('myfatoorah.callback'),
            route('myfatoorah.webhook'),
        );

        if (! $data) {
            session()->flash('error', trans('my_fatoorah::app.response.payment-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        return redirect()->away($data['PaymentURL']);
    }

    /**
     * Receive the customer coming back from the hosted payment page, and settle the payment.
     */
    public function callback(): RedirectResponse
    {
        $paymentId = request('paymentId');

        if (
            ! is_string($paymentId)
            || ! preg_match('/^[A-Za-z0-9-]{1,64}$/', $paymentId)
        ) {
            Log::warning('MyFatoorah: callback arrived with a malformed or missing paymentId.', [
                'paymentId' => $paymentId,
            ]);

            session()->flash('error', trans('my_fatoorah::app.response.payment-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        $order = $this->settle($paymentId);

        if (! $order) {
            session()->flash('error', trans('my_fatoorah::app.response.payment-failed'));

            return redirect()->route('shop.checkout.cart.index');
        }

        session()->flash('order_id', $order->id);

        session()->flash('success', trans('my_fatoorah::app.response.payment-success'));

        return redirect()->route('shop.checkout.onepage.success');
    }

    /**
     * Handle a server-to-server notification from MyFatoorah.
     */
    public function webhook(): JsonResponse
    {
        $secretKey = core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key');

        if (
            ! core()->getConfigData('sales.payment_methods.myfatoorah.is_webhook_enabled')
            || empty($secretKey)
        ) {
            return new JsonResponse(['status' => 'webhook_disabled'], 404);
        }

        $signature = (string) request()->header('MyFatoorah-Signature');

        $payload = json_decode(request()->getContent(), true);

        if (
            ! is_array($payload)
            || empty($payload['Data'])
            || ! WebhookSignature::isValid($payload, $secretKey, $signature)
        ) {
            return new JsonResponse(['status' => 'invalid_signature'], 404);
        }

        if (($payload['Event']['Code'] ?? null) !== 1) {
            return new JsonResponse(['status' => 'ignored']);
        }

        $paymentId = $payload['Data']['Transaction']['PaymentId'] ?? null;

        if (empty($paymentId)) {
            return new JsonResponse(['status' => 'no_payment_id']);
        }

        $order = $this->settle($paymentId);

        return new JsonResponse(['status' => $order ? 'order_placed' : 'payment_not_confirmed']);
    }

    /**
     * Confirm a payment with MyFatoorah and turn it into an order.
     */
    protected function settle(string $paymentId): ?OrderContract
    {
        $data = $this->myfatoorah->getPaymentDetails($paymentId);

        if (! $data) {
            Log::warning('MyFatoorah: could not fetch payment details.', ['paymentId' => $paymentId]);

            return null;
        }

        if (
            ($data['Invoice']['Status'] ?? null) !== 'PAID'
            || ($data['Transaction']['Status'] ?? null) !== 'SUCCESS'
        ) {
            Log::warning('MyFatoorah: payment is not settled yet.', [
                'paymentId' => $paymentId,
                'invoiceStatus' => $data['Invoice']['Status'] ?? null,
                'transactionStatus' => $data['Transaction']['Status'] ?? null,
            ]);

            return null;
        }

        $cartId = (int) ($data['Invoice']['ExternalIdentifier'] ?? 0);

        if (! $cartId) {
            Log::warning('MyFatoorah: payment carries no cart reference.', [
                'paymentId' => $paymentId,
                'invoice' => $data['Invoice'] ?? null,
            ]);

            return null;
        }

        return $this->placeOrder($cartId, $paymentId, $data);
    }

    /**
     * Turn a paid payment into an order once, however many times the customer and MyFatoorah report it.
     */
    protected function placeOrder(int $cartId, string $paymentId, array $data): ?OrderContract
    {
        return Cache::lock('myfatoorah.order.'.$cartId, 30)->block(10, function () use ($cartId, $paymentId, $data) {
            if ($order = $this->orderRepository->findOneWhere(['cart_id' => $cartId])) {
                return $order;
            }

            $cart = $this->cartRepository->find($cartId);

            if (
                ! $cart
                || ! $cart->is_active
            ) {
                Log::warning('MyFatoorah: cart for a confirmed payment is gone or inactive.', [
                    'paymentId' => $paymentId,
                    'cartId' => $cartId,
                ]);

                return null;
            }

            Cart::setCart($cart);

            core()->setCurrentCurrency($cart->cart_currency_code);

            Cart::collectTotals();

            $cart = Cart::getCart();

            if (
                ! $cart
                || Cart::hasError()
            ) {
                Log::warning('MyFatoorah: cart failed validation after collecting totals.', [
                    'paymentId' => $paymentId,
                    'cartId' => $cartId,
                ]);

                return null;
            }

            if (! $this->amountMatches($cart, $data)) {
                Log::warning('MyFatoorah: amount reported does not match the cart total.', [
                    'paymentId' => $paymentId,
                    'cartId' => $cartId,
                    'cartGrandTotal' => $cart->grand_total,
                    'cartCurrency' => $cart->cart_currency_code,
                    'reportedAmount' => $data['Amount'] ?? null,
                ]);

                return null;
            }

            $orderData = (new OrderResource($cart))->jsonSerialize();

            $orderData['payment']['additional'] = [
                'myfatoorah_payment_id' => $paymentId,
                'myfatoorah_invoice_id' => $data['Invoice']['Id'] ?? null,
            ];

            $order = $this->orderRepository->create($orderData);

            $this->orderRepository->update(['status' => Order::STATUS_PROCESSING], $order->id);

            if ($order->canInvoice()) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                $this->orderTransactionRepository->create([
                    'order_id' => $order->id,
                    'transaction_id' => $data['Transaction']['Id'] ?? $paymentId,
                    'status' => $data['Transaction']['Status'] ?? 'SUCCESS',
                    'type' => $data['Transaction']['PaymentMethod'] ?? null,
                    'payment_method' => 'myfatoorah',
                    'amount' => $order->base_grand_total,
                    'data' => json_encode($data),
                    'invoice_id' => $invoice->id,
                ]);
            }

            Cart::deActivateCart();

            return $order;
        });
    }

    /**
     * Whether MyFatoorah reports having taken the cart's own total, in the cart's own currency.
     */
    protected function amountMatches($cart, array $data): bool
    {
        $currency = strtoupper((string) ($data['Amount']['DisplayCurrency'] ?? ''));

        if (
            $currency
            && $this->myfatoorah->getCurrency($cart) !== $currency
        ) {
            return false;
        }

        $amount = $data['Amount']['ValueInDisplayCurrency'] ?? null;

        if ($amount === null) {
            return true;
        }

        $decimal = $this->myfatoorah->getCurrencyDecimal($this->myfatoorah->getCurrency($cart));

        return round((float) $amount, $decimal) === round((float) $cart->grand_total, $decimal);
    }

    /**
     * Prepare invoice data for every item still to be invoiced.
     */
    protected function prepareInvoiceData(OrderContract $order): array
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }
}
