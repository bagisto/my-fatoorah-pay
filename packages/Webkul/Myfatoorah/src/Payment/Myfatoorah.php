<?php

namespace Webkul\Myfatoorah\Payment;

use Illuminate\Support\Facades\Storage;
use Webkul\Payment\Payment\Payment;

class Myfatoorah extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'myfatoorah';

    /**
     * Return myfatoorah redirect url.
     */
    public function getRedirectUrl()
    {
        if( (bool)core()->getConfigData('sales.payment_methods.myfatoorah.status')) {

            return route('myfatoorah.checkout');
        }

        throw new \Exception(trans('my_fatoorah::app.shop.checkout.method-unavailable'));
    }

    /**
     * Get payment method image.
     *
     * @return string
     */
    public function getImage()
    {
        $url = $this->getConfigData('logo');

        return $url ? Storage::url($url) :  @bagisto_asset('images/myfatoorah.png', 'myfatoorah');
    }
}
