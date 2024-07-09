<?php

namespace Webkul\Myfatoorah\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Exception;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\MyFatoorahRefund;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\OrderTransactionRepository;
use Webkul\Sales\Models\Order;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;

class MyFatoorahController extends Controller {

    /**
     * @var array
     */
    public $mfConfig = [];

    /**
     * Initiate MyFatoorah Configuration and Instances
     */
    public function __construct(
                protected OrderRepository $orderRepository, 
                protected OrderTransactionRepository $orderTransactionRepository,
                protected InvoiceRepository $invoiceRepository,
                protected CartRepository $cartRepository,
    ) {
        $this->mfConfig = [
            'apiKey'      => core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
            'isTest'      => (Boolean)core()->getConfigData('sales.payment_methods.myfatoorah.test_mode'),
            'countryCode' => core()->getConfigData('sales.payment_methods.myfatoorah.country_iso'),
        ];
    }

    /**
     * Redirect to MyFatoorah Invoice URL
     *
     * @return string
     */
    public function index() {
        try {
        
            $order  = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

            $curlData = $this->preparePayLoad($order);

            $curlData['PaymentMethodId'] = request('paymentMethodId') ? : 0;

            $curlData['SessionId'] = request('sessionId') ? : null;

            $mfObj   = new MyFatoorahPayment($this->mfConfig);
            
            $payment = $mfObj->getInvoiceURL($curlData, $curlData['PaymentMethodId'], $order->id,  $curlData['SessionId']);

            return redirect($payment['invoiceURL']);
        } catch (Exception $ex) {
            $exMessage = trans('myfatoorah.' . $ex->getMessage());
           
            return response()->json(['IsSuccess' => 'false', 'Message' => $exMessage]);
        }
    }

    /**
     * Prepare MyFatoorah PayLoad
     *
     * @param array $order
     *
     * @return array
     */
    private function preparePayLoad($order) {

        if ($order) {

            // dd($order);
            foreach($order->items as $item) {
                $InvoiceItems[] = [
                    'ItemName'  => $item->name,
                    'Quantity'  => $item->qty_ordered,
                    'UnitPrice' => $item->price,
                    'Weight'    => $item->total_weight,
                    
                ];
            }

            return [
                'CustomerName'       => $order->customer_first_name. ' '.$order->customer_last_name,
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
     * Get MyFatoorah Payment Information
     * Provide the callback method with the paymentId
     *
     * @return redirect
     */
    public function callback()
    {
        try {
            $paymentId = request('paymentId');

            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            
            $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

            $message = $this->getMessage($data->InvoiceStatus, $data->InvoiceError);

            $orderStatus = $data->InvoiceStatus == 'Paid' ?  Order::STATUS_PROCESSING : Order::STATUS_CANCELED ;
            
            $customerId = $data->CustomerReference;
            
            $order = $this->orderRepository->where('customer_id', $customerId)->latest()->first();

            $invoice = null;

            if ($data->InvoiceStatus == 'Paid' && $order->canInvoice()) {

                $prepareInvoiceData = $this->prepareInvoiceData($order);

                $invoice = $this->invoiceRepository->create($prepareInvoiceData);

                $this->invoiceRepository->find($invoice->id)->update(['transaction_id' => $data->focusTransaction->TransactionId]);
            }


            $order->update(['status' => $orderStatus]);
            
            $orderTransaction =$this->orderTransactionRepository->where('order_id', $order->id)->count();
            
            if ($orderTransaction == 0) {
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
        } catch (Exception $ex) {
            $exMessage = trans('myfatoorah.' . $ex->getMessage());
            
            return view('myfatoorah::shop.error', compact('exMessage'));
        }
    
        Cart::activateCart($order->cart_id);
        
        session()->flash('order', $order);

        Cart::deActivateCart();

        return redirect()->route('shop.checkout.onepage.success');

    }

    protected function prepareInvoiceData($order): array
    {
        $invoiceData = ["order_id" => $order->id];

        foreach ($order->items as $item) {
            $invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
        }

        return $invoiceData;
    }

    /**
     * MyFatoorah Payment Methods
     *
     * @return View
     */
    public function checkout() {
        try {
            $cart = Cart::getCart();
            
            $order = $this->orderRepository->where('cart_id', $cart->id);
            
            if ($order->count() == 0) {
                $order = $this->orderRepository->create(Cart::prepareDataForOrder());
            }

            $order = $order->latest()->first();
            
            $orderId = $order->id;

            $customerId = $cart->customer_id;

            $userDefinedField = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            $mfObj = new MyFatoorahPaymentEmbedded($this->mfConfig);

            $paymentMethods = $mfObj->getCheckoutGateways($order->grand_total, $order->order_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);

            $countryCode = $this->mfConfig['countryCode'];

            $countries = MyFatoorah::getMFCountries();

            $jsEnvironment  = ($this->mfConfig['isTest']) ? $countries[$countryCode]['testPortal'] : $countries[$countryCode]['portal'];

            return view('myfatoorah::shop.checkout', compact('mfSession', 'paymentMethods', 'jsEnvironment', 'userDefinedField'));
        } catch (Exception $ex) {
            $exMessage = trans('myfatoorah.' . $ex->getMessage());

            return view('myfatoorah::shop.error', compact('exMessage'));
        }
    }


    /**
     * MyFatoorah Webhook
     * 
     * @param Request $request
     * 
     * @return void 
     */
    public function webhook(Request $request) {
        try {
            //Validate webhook_secret_key
            $secretKey = core()->getConfigData('sales.payment_methods.myfatoorah.webhook_secret_key');
            if (empty($secretKey)) {
                return response(null, 404);
            }

            //Validate MyFatoorah-Signature
            $mfSignature = $request->header('MyFatoorah-Signature');
            if (empty($mfSignature)) {
                return response(null, 404);
            }

            //Validate input
            $data  = $request->getContent();
            $data = json_decode($data, true);
            if (empty($data['Data']) || empty($data['EventType']) || $data['EventType'] != 1) {
                return response(null, 404);
            }

            //Validate Signature
            if (!MyFatoorah::isSignatureValid($data['Data'], $secretKey, $mfSignature, $data['EventType'])) {
                return response(null, 404);
            }

            //Update Transaction status on your system
            $result = $this->changeTransactionStatus($data['Data']);

            return response()->json($result);
        } catch (Exception $ex) {
            $exMessage = trans('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => false, 'Message' => $exMessage]);
        }
    }


    /**
     * MyFatoorah Refund
     *
     *@param  \Webkul\Sales\Contracts\Transaction  $transaction
     *
     * @return void
     */
    public function refund($transaction)
    {
        try{
            $order = $this->orderRepository->find($transaction->order_id);
            $myFatoorahRefund = new MyFatoorahRefund($this->mfConfig);

            $postFields = [
                'Key'                     => json_decode($transaction->data)->InvoiceId,
                'KeyType'                 => 'InvoiceId',
                'RefundChargeOnCustomer'  => false,
                'ServiceChargeOnCustomer' => false,
                'Amount'                  => $transaction->amount,
                'CurrencyIso'             => $order->order_currency_code,
            ];

            $result = $myFatoorahRefund->makeRefund($postFields);

            return $result ? true : false;
        } catch (Exception $ex) {
           return false;
        }
    }
    


    /**
     * Change Transaction Status
     *
     * @param  array  $data
     *
     * @return void
     */
    private function changeTransactionStatus($data) 
    {
        
        $invoiceId = $data['InvoiceId'];

        if ($data['TransactionStatus'] == 'SUCCESS') {
            $status = 'Paid';
            $error  = '';
        } else {
            $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            $data  = $mfObj->getPaymentStatus($invoiceId, 'InvoiceId');

            $status = $data->InvoiceStatus;
            $error  = $data->InvoiceError;
        }

        $message = $this->getMessage($status, $error);

        //4. Update order transaction status on your system
        return ['IsSuccess' => true, 'Message' => $message, 'Data' => $inputData];
    }


    /**
     * Get Message
     *
     * @return string
     */
    private function getMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
    }
    
    /**
     * Call Back If Error Occurs
     * 
     * @return view
     */
    public function callBackError() 
    {
        $paymentId = request('paymentId');

        $mfObj = new MyFatoorahPaymentStatus($this->mfConfig);
            
        $data  = $mfObj->getPaymentStatus($paymentId, 'PaymentId');

        $exMessage = $this->getMessage($data->InvoiceStatus, $data->InvoiceError);
        
        $orderId = $data->CustomerReference;
            
        $order = $this->orderRepository->where('customer_id', $orderId)->latest()->first();

       
        $invoice = null;
        
        $orderStatus = $data->InvoiceStatus == 'Success' ?  Order::STATUS_PROCESSING : Order::STATUS_CANCELED ;
        
        $order->update(['status' => $orderStatus]);

        $dd = $this->orderTransactionRepository->create([
            'order_id'      => $order->id,
            'transaction_id' => $data->InvoiceTransactions[0]->TransactionId,
            'status'        => $data->InvoiceStatus,
            'amount'        => $data->InvoiceValue,
            'payment_type'  => 'myfatoorah',
            'data'    => json_encode($data),
            'invoice_id'    => $invoice ? $invoice->id : 00,
        ]);
        Cart::activateCart($order->cart_id);

        Cart::deActivateCart();

        return view('myfatoorah::shop.error', compact('exMessage'));
        
    }
}
