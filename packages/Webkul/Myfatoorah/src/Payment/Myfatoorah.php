<?php

namespace Webkul\Myfatoorah\Payment;

use Webkul\Payment\Payment\Payment;
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
