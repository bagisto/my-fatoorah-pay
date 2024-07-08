<?php

namespace Webkul\Myfatoorah\Payment;

use Webkul\Payment\Payment\Payment;
use Webkul\Checkout\Facades\Cart;
class Myfatoorah extends Payment
{
   /**
     * Payment method code.
     *
     * @var string
     */
    protected $code  = 'myfatoorah';
    /**
     * Return myfatoorah redirect url.
     */
    public function getRedirectUrl()
    {
        return route('myfatoorah.checkout');
    }
}
