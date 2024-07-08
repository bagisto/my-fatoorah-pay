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
     * Initiate MyFatoorah Configuration
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
     * Provide the index method with the order id and (payment method id or session id)
     *
     * @return string
     */
    public function index() {
        try {
            //For example: pmid=0 for MyFatoorah invoice or pmid=1 for Knet in test mode
            $paymentId = request('pmid') ? : 0;

            $sessionId = request('sid') ? : null;
            
            $order  = $this->orderRepository->where('cart_id', Cart::getCart()->id)->latest()->first();

            $curlData = $this->getPayLoadData($order);

            $curlData['PaymentMethodId'] = $paymentId;

            $curlData['SessionId'] = $sessionId;


            $mfObj   = new MyFatoorahPayment($this->mfConfig);
            $payment = $mfObj->getInvoiceURL($curlData, $paymentId, $order->id, $sessionId);

            return redirect($payment['invoiceURL']);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => 'false', 'Message' => $exMessage]);
        }
    }

//-----------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Example on how to map order data to MyFatoorah
     * You can get the data using the order object in your system
     * 
     * @param int|string $orderId
     * 
     * @return array
     */
    private function getPayLoadData($order) {

        if ($order) {

            // dd($order);
            foreach($order->items as $item) {
                $InvoiceItems[] = [
                    'ItemName' => $item->name,
                    'Quantity' => $item->qty_ordered,
                    'UnitPrice' => $item->price,
                    'Weight' => $item->total_weight,
                    
                ];
            }
            return [
                'CustomerName'       => $order->customer_first_name. ' '.$order->customer_last_name,
                'InvoiceValue'       => $order->grand_total,
                'DisplayCurrencyIso' => $order->order_currency_code,
                'CustomerEmail'      => $order->customer_email,
                'CustomerAddress'    => [
                                            'Address' => $order->addresses[0]->address,
                                            'City' => $order->addresses[0]->city,
                                            'Country' => $order->addresses[0]->country,
                                            'PostalCode' => $order->addresses[0]->postcode,
                                            'State' => $order->addresses[0]->state,
                                        ],
                'CallBackUrl'        => route('myfatoorah.callback'),
                'ErrorUrl'           => route('myfatoorah.error'),
                'MobileCountryCode'  => '+965',
                'CustomerMobile'     => Cart::getCart()->shipping_address->phone,
                'Language'           => core()->getCurrentLocale()->code,
                'CustomerReference'  => $order->customer_id,
            ];
        }
    }

    /**
     * Get MyFatoorah Payment Information
     * Provide the callback method with the paymentId
     * 
     * @return Response
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

            if ($orderStatus == 'Paid' && $order->canInvoice()) {

                $prepareInvoiceData = $this->prepareInvoiceData($order);

                $prepareInvoiceData['invoice']['transaction_id'] = $data->TransactionId;
                
                $invoice = $this->invoiceRepository->create($prepareInvoiceData);
            }

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

            

        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            
            return view('myfatoorah::error', compact('exMessage'));
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
     * Example on how to Display the enabled gateways at your MyFatoorah account to be displayed on the checkout page
     * Provide the checkout method with the order id to display its total amount and currency
     * 
     * @return View
     */
    public function checkout1() {
        try {
            $cart = Cart::getCart();

            $order = $this->orderRepository->create(Cart::prepareDataForOrder());

            $orderId = $order->id;

            $customerId = $cart->customer_id;

            $userDefinedField = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            $mfObj = new MyFatoorahPaymentEmbedded($this->mfConfig);

            $paymentMethods = $mfObj->getCheckoutGateways($order->grand_total, $order->order_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            //Generate MyFatoorah session for embedded payment
            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);

            //Get Environment url
            $isTest = $this->mfConfig['isTest'];
            
            $countryCode = $this->mfConfig['countryCode'];
            
            $countries = MyFatoorah::getMFCountries();
            
            $jsEnvironment  = ($isTest) ? $countries[$countryCode]['testPortal'] : $countries[$countryCode]['portal'];
            
            return view('myfatoorah::checkout', compact('mfSession', 'paymentMethods', 'jsEnvironment', 'userDefinedField'));
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
           
            return view('myfatoorah::error', compact('exMessage'));
        }
    }

    public function getPaymentMethods() {

        try {
        
            $cart = Cart::getCart();

            $order = $this->orderRepository->create(Cart::prepareDataForOrder());

            $orderId = $order->id;

            $customerId = $cart->customer_id;

            $userDefinedField = core()->getConfigData('sales.payment_methods.myfatoorah.save_card') && $customerId ? "CK-$customerId" : '';

            $mfObj = new MyFatoorahPaymentEmbedded($this->mfConfig);
            
            $paymentMethods = $mfObj->getCheckoutGateways($order->grand_total, $order->order_currency_code, core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay'));

            if (empty($paymentMethods['all'])) {
                throw new Exception('noPaymentGateways');
            }

            $mfSession = $mfObj->getEmbeddedSession($userDefinedField);
            
            $vcCode = $this->mfConfig['countryCode'];
            
            $countries = MyFatoorah::getMFCountries();
            
            $jsDomain  = ($this->mfConfig['isTest']) ? $countries[$vcCode]['testPortal'] : $countries[$vcCode]['portal'];

            return compact('mfSession', 'paymentMethods', 'jsDomain', 'userDefinedField');
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return view('myfatoorah.error', compact('exMessage'));
        }
    }
    
    /**
     * Example on how the webhook is working when MyFatoorah try to notify your system about any transaction status update
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
            $body  = $request->getContent();
            $input = json_decode($body, true);
            if (empty($input['Data']) || empty($input['EventType']) || $input['EventType'] != 1) {
                return response(null, 404);
            }

            //Validate Signature
            if (!MyFatoorah::isSignatureValid($input['Data'], $secretKey, $mfSignature, $input['EventType'])) {
                return response(null, 404);
            }

            //Update Transaction status on your system
            $result = $this->changeTransactionStatus($input['Data']);

            return response()->json($result);
        } catch (Exception $ex) {
            $exMessage = __('myfatoorah.' . $ex->getMessage());
            return response()->json(['IsSuccess' => false, 'Message' => $exMessage]);
        }
    }


    /**
     * Get message
     *
     * 
     * @return voide
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

            return true;
        } catch (Exception $ex) {
           return false;
        }
    }
    

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function changeTransactionStatus($inputData) {
        //1. Check if orderId is valid on your system.
        $orderId = $inputData['CustomerReference'];

        //2. Get MyFatoorah invoice id
        $invoiceId = $inputData['InvoiceId'];

        //3. Check order status at MyFatoorah side
        if ($inputData['TransactionStatus'] == 'SUCCESS') {
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

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getTestOrderData($orderId) {
        return [
            'total'    => 15,
            'currency' => 'KWD'
        ];
    }

//-----------------------------------------------------------------------------------------------------------------------------------------
    private function getMessage($status, $error) {
        if ($status == 'Paid') {
            return 'Invoice is paid.';
        } else if ($status == 'Failed') {
            return 'Invoice is not paid due to ' . $error;
        } else if ($status == 'Expired') {
            return $error;
        }
    }
    
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

        return view('myfatoorah::error', compact('exMessage'));
        
    }
}
