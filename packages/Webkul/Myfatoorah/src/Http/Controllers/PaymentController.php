<?php

namespace Webkul\Myfatoorah\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use MyFatoorah\Library\API\MyFatoorahRefund;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use MyFatoorah\Library\MyFatoorah;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;

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
     * Initiate Myfatoorah configuration and instances
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
        protected CartRepository $cartRepository,
        protected MyFatoorah $myFatoorah,
        protected MyFatoorahPaymentEmbedded $myFatoorahPaymentEmbedded,
        protected MyFatoorahPayment $myFatoorahPayment,
        protected MyFatoorahRefund $myFatoorahRefund,
        protected MyFatoorahPaymentStatus $myFatoorahPaymentStatus,
    ) {}

    /**
     * Redirect to Myfatoorah invoice url
     *
     * @return redirect|JsonResponse
     */
    public function index()
    {
        try {
            $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

            return redirect($this->myFatoorahPayment->getInvoiceURL($this->preparePayLoad($order), (request('paymentMethodId') ?? 0), $order->id, (request('sessionId') ?? null))['invoiceURL']);
        } catch (Exception $exception) {

            return view('myfatoorah::shop.error', ['errorMessage' => $exception->getMessage()]);
        }
    }

    /**
     * Prepare Myfatoorah payLoad
     *
     * @param  object  $order
     */
    private function preparePayLoad($order): array
    {
        if ($order) {

            return [
                'CustomerName'       => $order->customer_first_name.' '.$order->customer_last_name,
                'InvoiceValue'       => $order->grand_total,
                'DisplayCurrencyIso' => $order->order_currency_code,
                'CustomerEmail'      => $order->customer_email,
                'CustomerAddress'    => [
                    'Address'    => $order->addresses[0]->address,
                    'City'       => $order->addresses[0]->city,
                    'Country'    => $order->addresses[0]->country,
                    'PostalCode' => $order->addresses[0]->postcode,
                    'State'      => $order->addresses[0]->state,
                ],
                'CallBackUrl'        => route('myfatoorah.callback'),
                'ErrorUrl'           => route('myfatoorah.error'),
                'CustomerMobile'     => $order->addresses[0]->phone,
                'Language'           => core()->getCurrentLocale()->code,
                'CustomerReference'  => $order->customer_id,
            ];
        }
    }

    /**
     * Update transaction after Myfatoorah payment process
     *
     * @return redirect|view
     */
    public function callback()
    {
        try {
            $data = $this->myFatoorahPaymentStatus->getPaymentStatus(request('paymentId'), 'PaymentId');

            $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

            $invoice = null;

            if (
                $data->InvoiceStatus == self::PAID
                && $order->canInvoice()
                && (! $this->invoiceRepository->where('order_id', $order->id)->count())
            ) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                $this->invoiceRepository->find($invoice->id)->update(['transaction_id' => $data->focusTransaction->TransactionId]);
            }

            $order->update(['status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED]);

            if (! $this->orderTransactionRepository->where('order_id', $order->id)->count()) {
                $this->orderTransactionRepository->create([
                    'order_id'       => $order->id,
                    'transaction_id' => $data->focusTransaction->TransactionId,
                    'status'         => $data->InvoiceStatus,
                    'amount'         => $data->InvoiceValue,
                    'payment_type'   => 'myfatoorah',
                    'data'           => json_encode($data),
                    'invoice_id'     => $invoice ? $invoice->id : 00,
                ]);
            }
        } catch (Exception $exception) {

            return view('myfatoorah::shop.error', ['errorMessage' => $exception->getMessage()]);
        }

        session()->flash('order', $order);

        Cart::deActivateCart();

        return redirect()->route('shop.checkout.onepage.success');
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
     * Myfatoorah payment
     *
     * @return View
     */
    public function checkout()
    {
        try {
            $cart = Cart::getCart();

            $order = $this->orderRepository->where('cart_id', $cart->id);

            if (! $order->count()) {
                $order = $this->orderRepository->create(Cart::prepareDataForOrder());
            }

            $order = $order->latest()->first();

            $saveCard = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $cart->customer_id ? "CK-$cart->customer_id" : '';

            $paymentMethods = $this->myFatoorahPaymentEmbedded->getCheckoutGateways($order->grand_total, $order->order_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception(trans('my_fatoorah::app.shop.checkout.noPaymentGateways'));
            }

            $paymentSession = $this->myFatoorahPaymentEmbedded->getEmbeddedSession($saveCard);

            $countryCode = core()->getConfigData('sales.payment_methods.myfatoorah.country_iso');

            $countries = MyFatoorah::getMFCountries();

            $jsEnvironment = ((bool) core()->getConfigData('sales.payment_methods.myfatoorah.test_mode')) ? $countries[$countryCode]['testPortal'] : $countries[$countryCode]['portal'];

            return view('myfatoorah::shop.checkout', compact('paymentSession', 'paymentMethods', 'jsEnvironment', 'saveCard'));
        } catch (Exception $exception) {

            return view('myfatoorah::shop.error', ['errorMessage' => $exception->getMessage()]);
        }
    }

    /**
     * Myfatoorah webhook
     */
    public function webhook(): JsonResponse
    {
        try {
            $secretKey = core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key');

            $mfSignature = request()->header('MyFatoorah-Signature');

            $data = json_decode(request()->getContent(), true);

            if (
                MyFatoorah::isSignatureValid($data['Data'], $secretKey, $mfSignature, $data['EventType'])
                && $data['Data']
                && $data['EventType']
                && $mfSignature
                && $secretKey
            ) {

                return new JsonResponse($this->changeTransactionStatus($data['Data']), 200);
            }

            return new JsonResponse(['success' => false, 'message' => trans('my_fatoorah::app.shop.checkout.error-occurred')], 404);
        } catch (Exception $exception) {

            return new JsonResponse(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }

    /**
     * Change transaction status
     *
     * @param  array  $data
     */
    private function changeTransactionStatus($data): array
    {
        $data = $this->myFatoorahPaymentStatus->getPaymentStatus($data['InvoiceId'], 'InvoiceId');

        $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

        $invoice = null;

        if (
            $data->InvoiceStatus == self::PAID
            && $order->canInvoice()
            && (! $this->invoiceRepository->where('order_id', $order->id)->count())
        ) {
            $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

            $this->invoiceRepository->find($invoice->id)->update(['transaction_id' => $data->focusTransaction->TransactionId]);
        }

        $order->update(['status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED]);

        if (! $this->orderTransactionRepository->where('order_id', $order->id)->count()) {
            $this->orderTransactionRepository->create([
                'order_id'       => $order->id,
                'transaction_id' => $data->focusTransaction->TransactionId,
                'status'         => $data->InvoiceStatus,
                'amount'         => $data->InvoiceValue,
                'payment_type'   => 'myfatoorah',
                'data'           => json_encode($data),
                'invoice_id'     => $invoice ? $invoice->id : 00,
            ]);
        }

        return ['success' => $data->InvoiceStatus == self::PAID ? true : false, 'message' => $this->getMessage($data->InvoiceStatus, $data->InvoiceError), 'data' => $data];
    }

    /**
     * Get message
     *
     * @param  string  $status,  $error
     * @return string
     */
    private function getMessage($status, $error)
    {
        switch ($status) {
            case self::PAID:
                return trans('myfatoorah::app.chckout.invoice-success');

            case self::FAILED:
                return trans('myfatoorah::app.chckout.invoice-failed', ['error' => $error]);

            case self::EXPIRED:
                return $error;
        }
    }

    /**
     * Call back if error occurs
     *
     * @return view
     */
    public function callBackError()
    {
        $data = $this->myFatoorahPaymentStatus->getPaymentStatus(request('paymentId'), 'PaymentId');

        $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

        $order->update(['status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED]);

        $this->orderTransactionRepository->create([
            'order_id'       => $order->id,
            'transaction_id' => $data->InvoiceTransactions[0]->TransactionId,
            'status'         => $data->InvoiceStatus,
            'amount'         => $data->InvoiceValue,
            'payment_type'   => 'myfatoorah',
            'data'           => json_encode($data),
            'invoice_id'     => 00,
        ]);

        Cart::deActivateCart();

        return view('myfatoorah::shop.error', ['errorMessage' => $this->getMessage($data->InvoiceStatus, $data->InvoiceError)]);
    }
}
