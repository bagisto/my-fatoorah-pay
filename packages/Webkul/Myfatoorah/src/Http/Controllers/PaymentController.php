<?php

namespace Webkul\Myfatoorah\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Models\CartPayment;
use Webkul\Shop\Http\Controllers\API\OnepageController;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Myfatoorah\Commands\RegisterApplePay;

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
     * Initiate myfatoorah configuration and instances
     */
    public function __construct(
        protected MyFatoorah $myFatoorah,
        protected MyFatoorahPaymentEmbedded $myFatoorahPaymentEmbedded,
        protected MyFatoorahPayment $myFatoorahPayment,
        protected MyFatoorahPaymentStatus $myFatoorahPaymentStatus,
        protected OrderRepository $orderRepository,
        protected OrderTransactionRepository $orderTransactionRepository,
        protected InvoiceRepository $invoiceRepository,
        protected OnepageController $onepageController,
        protected RegisterApplePay $registerApplePay
    ) {}

    /**
     * Redirect to myfatoorah invoice url
     *
     * @return redirect|JsonResponse
     */
    public function index()
    {
        try {
            $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();
        
            $invoiceUrl = $this->myFatoorahPayment->getInvoiceURL($this->preparePayLoad($order), (request('paymentMethodId') ?? 0), $order->id, (request('sessionId') ?? null));
            
            info("Myfatoorah Payload:". json_encode($this->preparePayLoad($order)));

            info("Payment Method Id". request('paymentMethodId') ?? 0);
            
            info("session :". request('sessionId'));

            info("invoice:". json_encode($invoiceUrl));
            
            return redirect($invoiceUrl['invoiceURL']);
        } catch (Exception $exception) {
            info("index >>>".$exception->getMessage());
            
            return view('myfatoorah::shop.error', [
                'errorMessage' => 'something went wrong please try again',
            ]);
        }
    }

    /**
     * Prepare myfatoorah payLoad
     *
     * @param  object  $order
     * @return array
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
                'CustomerMobile'     => substr($order->addresses[0]->phone,1,11),
                'Language'           => core()->getCurrentLocale()->code,
                'CustomerReference'  => $order->customer_id,
            ];
        }
    }

    /**
     * Update transaction after myfatoorah payment process
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
                && ( empty($this->invoiceRepository->where('order_id', $order->id)->first()))
            ) {
                $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

                $this->invoiceRepository->find($invoice->id)->update([
                    'transaction_id' => $data->focusTransaction->TransactionId,
                ]);
            }

            $order->update([
                'status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED,
            ]);

            if ( empty($this->orderTransactionRepository->where('order_id', $order->id)->first())) {
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
            info("callback >>>".$exception->getMessage());

            return view('myfatoorah::shop.error', [
                'errorMessage' => 'something went wrong please try again',
            ]);
        }

        session()->flash('order', $order);

        Cart::deActivateCart();

        return redirect()->route('shop.checkout.onepage.success');
    }

    /**
     * Prepare invoice data
     *
     * @param  object  $order
     * @return array
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

            if ( empty($order->first())) {
                $order = $this->orderRepository->create(Cart::prepareDataForOrder());
            }

            $order = $order->latest()->first();

            $saveCard = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $cart->customer_id ? "CK-$cart->customer_id" : '';

            $paymentMethods = $this->myFatoorahPaymentEmbedded->getCheckoutGateways($order->grand_total, $order->order_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if ( empty($paymentMethods['all'])) {
                throw new Exception(trans('my_fatoorah::app.shop.checkout.noPaymentGateways'));
            }

            $paymentSession = $this->myFatoorahPaymentEmbedded->getEmbeddedSession($saveCard);

            $countryCode = core()->getConfigData('sales.payment_methods.myfatoorah.country_iso');

            $countries = MyFatoorah::getMFCountries();

            $jsEnvironment = ((bool) core()->getConfigData('sales.payment_methods.myfatoorah.test_mode')) ? $countries[$countryCode]['testPortal'] : $countries[$countryCode]['portal'];

            return view('myfatoorah::shop.checkout', compact('paymentSession', 'paymentMethods', 'jsEnvironment', 'saveCard'));
        } catch (Exception $exception) {
            info("Chckout error >>>".$exception->getMessage());

            return view('myfatoorah::shop.error', [
                'errorMessage' => 'something went wrong please try again',
            ]);
        }
    }

    /**
     * Update transaction status when webhook is triggered from myfatoorah
     */
    public function updateStatus(): JsonResponse
    {
        try {
            $secretKey = core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key');

            if ( empty($secretKey)) {
                return new JsonResponse([
                    'success' => false, 
                    'message' => trans('my_fatoorah::app.shop.checkout.no-webhook-secretKey'),
                ], 404);
            }

            $mfSignature = request()->header('MyFatoorah-Signature');

            $data = json_decode(request()->getContent(), true);

            if (MyFatoorah::isSignatureValid($data['Data'], $secretKey, $mfSignature, $data['EventType'])) {
                return new JsonResponse($this->changeTransactionStatus($data['Data']), 200);
            }

            return new JsonResponse([
                'success' => false,
                'message' => trans('my_fatoorah::app.shop.checkout.error-occurred'),
            ], 404);
        } catch (Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Change transaction status
     *
     * @param  array  $data
     * @return array
     */
    private function changeTransactionStatus($data): array
    {
        $data = $this->myFatoorahPaymentStatus->getPaymentStatus($data['InvoiceId'], 'InvoiceId');

        $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

        $invoice = null;

        if (
            $data->InvoiceStatus == self::PAID
            && $order->canInvoice()
            && ( empty($this->invoiceRepository->where('order_id', $order->id)->first()))
        ) {
            $invoice = $this->invoiceRepository->create($this->prepareInvoiceData($order));

            $this->invoiceRepository->find($invoice->id)->update([
                'transaction_id' => $data->focusTransaction->TransactionId,
            ]);
        }

        $order->update([
            'status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED,
        ]);

        if ( empty($this->orderTransactionRepository->where('order_id', $order->id)->first())) {
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

        return [
            'success' => $data->InvoiceStatus == self::PAID ? true : false,
            'message' => $this->getMessage($data->InvoiceStatus, $data->InvoiceError), 
            'data'    => $data,
        ];
    }

    /**
     * Get message
     *
     * @param  string  $status
     * @param  string  $error
     * @return string
     */
    private function getMessage($status, $error)
    {
        info("status of the payment :".$status);

        info("Message :".$error);

        switch ($status) {
            case self::PAID:
                return trans('my_fatoorah::app.shop.checkout.invoice-success');

            case self::FAILED:
                return trans('my_fatoorah::app.shop.checkout.invoice-failed', [
                    'error' => $error,
                ]);

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

        info("Back back error:".json_encode($data));

        $order = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

        $order->update([
            'status' => $data->InvoiceStatus == self::PAID ? Order::STATUS_PROCESSING : Order::STATUS_CANCELED,
        ]);

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

        return view('myfatoorah::shop.error', [
            'errorMessage' => $this->getMessage($data->InvoiceStatus, $data->InvoiceError),
        ]);
    }

    public function getMethods()
    {
        $cart = Cart::getCart();

        $saveCard = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $cart->customer_id ? "CK-$cart->customer_id" : '';
        
        $paymentMethods = $this->myFatoorahPaymentEmbedded->getCheckoutGateways($cart->grand_total, $cart->cart_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

        if ( empty($paymentMethods['all'])) {
            throw new Exception(trans('my_fatoorah::app.shop.checkout.noPaymentGateways'));
        }

        $paymentSession = $this->myFatoorahPaymentEmbedded->getEmbeddedSession($saveCard);

        $countryCode = core()->getConfigData('sales.payment_methods.myfatoorah.country_iso');

        $countries = MyFatoorah::getMFCountries();

        $jsEnvironment = ((bool) core()->getConfigData('sales.payment_methods.myfatoorah.test_mode')) ? $countries[$countryCode]['testPortal'] : $countries[$countryCode]['portal'];

        if(empty($paymentMethods['ap'])) {
            foreach($paymentMethods['all'] as $key => $value) {
                if($value->PaymentMethodCode == 'ap') { 
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

    public function getCartpayment()
    {
        return app(CartPayment::class)->where('cart_id', Cart::getCart()->id)->first();
    }

     /**
     * Store order
     */
    public function storeOrder()
    {
        if (Cart::hasError()) {
            return new JsonResource([
                'status'     => false,
            ]);
        }

        Cart::collectTotals();

        try {
            $this->onepageController->validateOrder();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        $cart = Cart::getCart();

        $order = $this->orderRepository->where('cart_id', $cart->id)->first();

        if ( empty($order)) {
            $order = $this->orderRepository->create(Cart::prepareDataForOrder());
        }

        return new JsonResponse([
            'success' => true,
            'order'   => $order,
        ]);
    }

    public function cancelOrder() {
        $cart = Cart::getCart();

        $this->orderRepository->where('cart_id', $cart->id)->update([
            'status' => Order::STATUS_CANCELED
        ]);

        Cart::deActivateCart();

        return new JsonResponse([
            'redirect'     => true,
            'redirect_url' => route('shop.customer.session.index'),
        ]);
    }

    /**
     * Register Apple Pay
     *
     * @return redirect
     */
    public function mapApplePay()
    {
        if(request()->method() == 'GET') {
            return view('myfatoorah::admin.map-apple-pay');
        }

        $domainRegister = json_decode($this->registerApplePay->registerApplePay(request()->get('domain'))->getBody(), true);

        return redirect()->back()->with($domainRegister['IsSuccess'] ? 'success' : 'error', $domainRegister['Message']);
    }
}
