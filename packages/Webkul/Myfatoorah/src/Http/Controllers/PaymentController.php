<?php

namespace Webkul\Myfatoorah\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use MyFatoorah\Library\MyFatoorah;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Myfatoorah\Commands\RegisterApplePay;
use Webkul\Myfatoorah\Http\WebhookSignature;
use Webkul\Myfatoorah\Payment\Myfatoorah as MyfatoorahPaymentMethod;
use Webkul\Sales\Contracts\Order as OrderContract;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderCommentRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Transformers\OrderResource;
use Webkul\Shop\Http\Controllers\API\OnepageController;

class PaymentController extends Controller
{
    /**
     * @var string
     */
    const PAID = 'Paid';

    /**
     * @var string
     */
    const FAILED = 'Failed';

    /**
     * @var string
     */
    const EXPIRED = 'Expired';

    /**
     * Currencies MyFatoorah settles with three decimals.
     *
     * @var array
     */
    const THREE_DECIMAL_CURRENCIES = ['KWD', 'BHD', 'OMR', 'JOD'];

    /**
     * Initiate myfatoorah configuration and instances
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected OrderCommentRepository $orderCommentRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CartRepository $cartRepository,
        protected OnepageController $onepageController,
        protected RegisterApplePay $registerApplePay,
        protected MyfatoorahPaymentMethod $myfatoorah
    ) {}

    /**
     * Create the MyFatoorah invoice of the current cart and redirect to its payment url.
     *
     * @return RedirectResponse|View
     */
    public function index()
    {
        $validator = validator(request()->only('paymentMethodId', 'sessionId'), [
            'paymentMethodId' => ['nullable', 'integer', 'min:1'],
            'sessionId'       => ['nullable', 'string', 'max:100', 'regex:/^[A-Za-z0-9-]+$/'],
        ]);

        if ($validator->fails()) {
            return $this->errorView(trans('my_fatoorah::app.shop.checkout.error-occurred'));
        }

        try {
            $order = $this->getOrder();

            $invoice = app(MyFatoorahPayment::class)->getInvoiceURL(
                $this->preparePayLoad($order),
                request('paymentMethodId') ?: 0,
                $order->id,
                request('sessionId') ?: null
            );

            return redirect()->away($invoice['invoiceURL']);
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the payment could not be started.', [
                'message' => $exception->getMessage(),
            ]);

            return $this->errorView(trans('my_fatoorah::app.shop.checkout.error-occurred'));
        }
    }

    /**
     * Update transaction after myfatoorah payment process
     *
     * @return RedirectResponse|View
     */
    public function callback()
    {
        return $this->processPayment();
    }

    /**
     * Call back if error occurs
     *
     * @return RedirectResponse|View
     */
    public function callBackError()
    {
        return $this->processPayment();
    }

    /**
     * Myfatoorah payment
     *
     * @return RedirectResponse|View
     */
    public function checkout()
    {
        try {
            $cart = Cart::getCart();

            if (! $cart) {
                return redirect()->route('shop.checkout.cart.index');
            }

            $saveCard = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $cart->customer_id ? "CK-$cart->customer_id" : '';

            $myFatoorahPaymentEmbedded = app(MyFatoorahPaymentEmbedded::class);

            $paymentMethods = $myFatoorahPaymentEmbedded->getCheckoutGateways($cart->grand_total, $cart->cart_currency_code, (bool) core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception(trans('my_fatoorah::app.shop.checkout.no-payment-gateways'));
            }

            $paymentSession = $myFatoorahPaymentEmbedded->getEmbeddedSession($saveCard);

            $jsEnvironment = $this->myfatoorah->getJsEnvironment();

            return view('myfatoorah::shop.checkout', compact('paymentSession', 'paymentMethods', 'jsEnvironment', 'saveCard'));
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the payment methods could not be loaded.', [
                'message' => $exception->getMessage(),
            ]);

            return $this->errorView(trans('my_fatoorah::app.shop.checkout.error-occurred'));
        }
    }

    /**
     * Update transaction status when webhook is triggered from myfatoorah
     */
    public function updateStatus(): JsonResponse
    {
        $secretKey = core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key');

        if (
            ! core()->getConfigData('sales.payment_methods.myfatoorah.is_webhook_enabled')
            || empty($secretKey)
        ) {
            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.no-webhook-secretKey'),
            ], 404);
        }

        $signature = request()->header('MyFatoorah-Signature');

        if (empty($signature)) {
            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.no-webhook-signature'),
            ], 404);
        }

        $data = json_decode(request()->getContent(), true);

        if (
            ! is_array($data)
            || empty($data['Data'])
            || ! is_array($data['Data'])
        ) {
            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.invalid-webhook-data'),
            ], 400);
        }

        if (! $this->isWebhookSignatureValid($data, $secretKey, $signature)) {
            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.invalid-webhook-signature'),
            ], 404);
        }

        $invoiceId = isset($data['Event']['Code'])
            ? ($data['Event']['Code'] == 1 ? ($data['Data']['Invoice']['Id'] ?? null) : null)
            : (($data['EventType'] ?? null) == 1 ? ($data['Data']['InvoiceId'] ?? null) : null);

        if (empty($invoiceId)) {
            return new JsonResponse(['success' => true]);
        }

        try {
            $data = app(MyFatoorahPaymentStatus::class)->getPaymentStatus($invoiceId, 'InvoiceId');

            $this->changeTransactionStatus($data, $this->getVerifiedOrder($data));
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the webhook could not be processed.', [
                'invoiceId' => $invoiceId,
                'message'   => $exception->getMessage(),
            ]);

            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.error-occurred'),
            ], 500);
        }

        return new JsonResponse([
            'success' => $data->InvoiceStatus == self::PAID,
            'message' => $this->getMessage($data->InvoiceStatus, $data->InvoiceError),
        ]);
    }

    /**
     * Get the MyFatoorah payment methods of the current cart for the checkout page.
     */
    public function getMethods(): JsonResponse
    {
        try {
            $cart = Cart::getCart();

            if (! $cart) {
                throw new Exception(trans('my_fatoorah::app.shop.checkout.method-unavailable'));
            }

            $saveCard = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $cart->customer_id ? "CK-$cart->customer_id" : '';

            $myFatoorahPaymentEmbedded = app(MyFatoorahPaymentEmbedded::class);

            $paymentMethods = $myFatoorahPaymentEmbedded->getCheckoutGateways($cart->grand_total, $cart->cart_currency_code, (bool) core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception(trans('my_fatoorah::app.shop.checkout.no-payment-gateways'));
            }

            $paymentSession = $myFatoorahPaymentEmbedded->getEmbeddedSession($saveCard);

            $jsEnvironment = $this->myfatoorah->getJsEnvironment();
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the payment methods could not be loaded.', [
                'message' => $exception->getMessage(),
            ]);

            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.error-occurred'),
            ], 500);
        }

        if (empty($paymentMethods['ap'])) {
            foreach ($paymentMethods['all'] as $key => $value) {
                if ($value->PaymentMethodCode == 'ap') {
                    unset($paymentMethods['all'][$key]);
                }
            }
        }

        return new JsonResponse([
            'success'        => true,
            'paymentSession' => $paymentSession,
            'paymentMethods' => $paymentMethods['all'],
            'jsEnvironment'  => $jsEnvironment,
            'saveCard'       => $saveCard,
        ]);
    }

    /**
     * Register Apple Pay
     *
     * @return View|RedirectResponse
     */
    public function mapApplePay()
    {
        if (request()->isMethod('GET')) {
            return view('myfatoorah::admin.map-apple-pay');
        }

        request()->validate([
            'domain' => ['required', 'string', 'max:253', 'regex:/^(?!-)[A-Za-z0-9-]{1,63}(\.[A-Za-z0-9-]{1,63})+$/'],
        ]);

        try {
            $domainRegister = $this->registerApplePay->registerApplePay(request('domain'));
        } catch (Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with($domainRegister['IsSuccess'] ? 'success' : 'error', $domainRegister['Message']);
    }

    /**
     * Verify the payment MyFatoorah redirected the customer back with and show its result.
     *
     * @return RedirectResponse|View
     */
    protected function processPayment()
    {
        $paymentId = request('paymentId');

        if (
            ! is_string($paymentId)
            || ! preg_match('/^[A-Za-z0-9-]{1,64}$/', $paymentId)
        ) {
            return $this->errorView(trans('my_fatoorah::app.shop.checkout.error-occurred'));
        }

        try {
            $data = app(MyFatoorahPaymentStatus::class)->getPaymentStatus($paymentId, 'PaymentId');

            $order = $this->getVerifiedOrder($data);

            $this->changeTransactionStatus($data, $order);
        } catch (Exception $exception) {
            Log::error('MyFatoorah: the payment could not be verified.', [
                'paymentId' => $paymentId,
                'message'   => $exception->getMessage(),
            ]);

            return $this->errorView(trans('my_fatoorah::app.shop.checkout.error-occurred'));
        }

        if ($data->InvoiceStatus != self::PAID) {
            return $this->errorView($this->getMessage($data->InvoiceStatus, $data->InvoiceError));
        }

        if (! $this->isCustomerOrder($order)) {
            session()->flash('success', trans('my_fatoorah::app.shop.checkout.invoice-success'));

            return redirect()->route('shop.checkout.cart.index');
        }

        if (Cart::getCart()?->id == $order->cart_id) {
            Cart::deActivateCart();
        }

        session()->flash('order_id', $order->id);

        return redirect()->route('shop.checkout.onepage.success');
    }

    /**
     * Get the pending order of the current cart, creating it when the cart has none or has changed
     * since its pending order was created.
     *
     * @throws Exception
     */
    protected function getOrder(): OrderContract
    {
        $cart = Cart::getCart();

        if (
            ! $cart
            || Cart::hasError()
            || $cart->payment?->method != 'myfatoorah'
        ) {
            throw new Exception(trans('my_fatoorah::app.shop.checkout.method-unavailable'));
        }

        Cart::collectTotals();

        $this->onepageController->validateOrder();

        $cart = Cart::getCart();

        $data = (new OrderResource($cart))->jsonSerialize();

        $fingerprint = hash('sha256', json_encode($data));

        return Cache::lock('myfatoorah:cart:'.$cart->id, 30)->block(10, function () use ($cart, $data, $fingerprint) {
            $pendingOrders = $this->orderRepository->findWhere([
                'cart_id' => $cart->id,
                'status'  => Order::STATUS_PENDING,
            ])->filter(fn ($order) => $order->payment?->method == 'myfatoorah');

            foreach ($pendingOrders as $pendingOrder) {
                if (($pendingOrder->payment->additional['myfatoorah_cart'] ?? null) === $fingerprint) {
                    return $pendingOrder;
                }
            }

            foreach ($pendingOrders as $pendingOrder) {
                $this->orderRepository->cancel($pendingOrder);
            }

            $data['payment']['additional'] = ['myfatoorah_cart' => $fingerprint];

            return $this->orderRepository->create($data);
        });
    }

    /**
     * Find the order a MyFatoorah invoice was created for and check that the invoice is for the
     * order's amount and currency.
     *
     * @param  object  $data
     *
     * @throws Exception
     */
    protected function getVerifiedOrder($data): OrderContract
    {
        $order = is_numeric($data->CustomerReference ?? null)
            ? $this->orderRepository->find((int) $data->CustomerReference)
            : null;

        if (
            ! $order
            || $order->payment?->method != 'myfatoorah'
        ) {
            throw new Exception('The invoice does not belong to a MyFatoorah order.');
        }

        $displayValue = explode(' ', trim((string) ($data->InvoiceDisplayValue ?? '')), 2);

        $amount = (float) preg_replace('/[^\d.]/', '', $displayValue[0]);

        $decimals = in_array($order->order_currency_code, self::THREE_DECIMAL_CURRENCIES) ? 3 : 2;

        if (abs($amount - round((float) $order->grand_total, $decimals)) >= 10 ** -$decimals) {
            throw new Exception("The invoice amount does not match order #{$order->increment_id}.");
        }

        $currencies = array_merge(
            [$order->order_currency_code],
            array_values(MyFatoorahPaymentEmbedded::getTranslatedCurrency($order->order_currency_code))
        );

        if (! in_array(trim($displayValue[1] ?? ''), $currencies, true)) {
            throw new Exception("The invoice currency does not match order #{$order->increment_id}.");
        }

        return $order;
    }

    /**
     * Change transaction status
     *
     * @param  object  $data
     */
    private function changeTransactionStatus($data, OrderContract $order): void
    {
        Cache::lock('myfatoorah:order:'.$order->id, 30)->block(10, function () use ($data, $order) {
            DB::transaction(function () use ($data, $order) {
                $order = $this->orderRepository->find($order->id);

                $transactionId = (string) ($data->focusTransaction->TransactionId ?? '');

                if (
                    $transactionId !== ''
                    && $this->orderTransactionRepository->findOneWhere([
                        'order_id'       => $order->id,
                        'transaction_id' => $transactionId,
                    ])
                ) {
                    return;
                }

                if ($data->InvoiceStatus != self::PAID) {
                    if (in_array($data->InvoiceStatus, [self::FAILED, self::EXPIRED])) {
                        $this->orderRepository->cancel($order);
                    }

                    if ($transactionId !== '') {
                        $this->createTransaction($data, $order, $transactionId);
                    }

                    return;
                }

                if ($order->status != Order::STATUS_PENDING) {
                    $this->createTransaction($data, $order, $transactionId);

                    $this->orderCommentRepository->create([
                        'order_id'          => $order->id,
                        'comment'           => trans('my_fatoorah::app.admin.unexpected-payment', [
                            'transaction' => $transactionId,
                            'status'      => $order->status_label,
                        ]),
                        'customer_notified' => 0,
                    ]);

                    Log::warning('MyFatoorah: a payment was received for an order that is no longer pending.', [
                        'order'       => $order->increment_id,
                        'transaction' => $transactionId,
                    ]);

                    return;
                }

                $this->orderRepository->update(['status' => Order::STATUS_PROCESSING], $order->id);

                $invoice = null;

                if ($order->canInvoice()) {
                    $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                    $this->invoiceRepository->update(['transaction_id' => $transactionId], $invoice->id);
                }

                $this->createTransaction($data, $order, $transactionId, $invoice?->id);

                if ($this->cartRepository->find($order->cart_id)) {
                    $this->cartRepository->update(['is_active' => 0], $order->cart_id);
                }
            });
        });
    }

    /**
     * Record a MyFatoorah transaction against the order.
     *
     * @param  object  $data
     */
    private function createTransaction($data, OrderContract $order, string $transactionId, ?int $invoiceId = null): void
    {
        $this->orderTransactionRepository->create([
            'order_id'       => $order->id,
            'transaction_id' => $transactionId ?: (string) $data->InvoiceId,
            'status'         => $data->InvoiceStatus,
            'type'           => $data->focusTransaction->PaymentGateway ?? null,
            'payment_method' => 'myfatoorah',
            'amount'         => $order->base_grand_total,
            'data'           => json_encode($data),
            'invoice_id'     => $invoiceId ?? 0,
        ]);
    }

    /**
     * Prepare myfatoorah payLoad
     *
     * @param  object  $order
     */
    private function preparePayLoad($order): array
    {
        $address = $order->billing_address;

        $decimals = in_array($order->order_currency_code, self::THREE_DECIMAL_CURRENCIES) ? 3 : 2;

        return [
            'CustomerName'       => $order->customer_first_name.' '.$order->customer_last_name,
            'InvoiceValue'       => round((float) $order->grand_total, $decimals),
            'DisplayCurrencyIso' => $order->order_currency_code,
            'CustomerEmail'      => $order->customer_email,
            'CustomerAddress'    => [
                'Address'    => $address?->address,
                'City'       => $address?->city,
                'Country'    => $address?->country,
                'PostalCode' => $address?->postcode,
                'State'      => $address?->state,
            ],
            'CallBackUrl'        => route('myfatoorah.callback'),
            'ErrorUrl'           => route('myfatoorah.error'),
            'CustomerMobile'     => substr(preg_replace('/\D/', '', (string) $address?->phone), -11),
            'Language'           => core()->getCurrentLocale()->code == 'ar' ? 'ar' : 'en',
            'CustomerReference'  => $order->id,
        ];
    }

    /**
     * Prepare invoice data
     *
     * @param  object  $order
     */
    protected function prepareInvoiceData($order): array
    {
        $invoiceData = ['order_id' => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    /**
     * Get message
     *
     * @param  string  $status
     * @param  string  $error
     */
    private function getMessage($status, $error): string
    {
        return match ($status) {
            self::PAID    => trans('my_fatoorah::app.shop.checkout.invoice-success'),
            self::FAILED  => trans('my_fatoorah::app.shop.checkout.invoice-failed', ['error' => $error]),
            self::EXPIRED => (string) $error,
            default       => trans('my_fatoorah::app.shop.checkout.invoice-pending'),
        };
    }

    /**
     * Whether the order was placed by the visitor MyFatoorah redirected back.
     */
    private function isCustomerOrder(OrderContract $order): bool
    {
        if ($customer = auth()->guard('customer')->user()) {
            return $order->customer_id == $customer->id;
        }

        return $order->is_guest && session('cart')?->id == $order->cart_id;
    }

    /**
     * Whether the webhook request is signed with the webhook secret key, for webhook version 1 and 2.
     */
    private function isWebhookSignatureValid(array $data, string $secretKey, string $signature): bool
    {
        try {
            if (isset($data['Event']['Code'])) {
                return WebhookSignature::isValidV2($data, $secretKey, $signature);
            }

            return MyFatoorah::isSignatureValid($data['Data'], $secretKey, $signature, $data['EventType'] ?? 1);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Render the MyFatoorah error page.
     */
    private function errorView(string $message): View
    {
        return view('myfatoorah::shop.error', [
            'errorMessage' => $message,
        ]);
    }
}
