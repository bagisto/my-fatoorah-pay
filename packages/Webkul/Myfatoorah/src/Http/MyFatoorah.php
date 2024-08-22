<?php

namespace Webkul\Myfatoorah\Http;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Payment\Facades\Payment;
use Webkul\Checkout\Facades\Cart;
class MyFatoorah
{
    public function myfatoorahEnabled()
    {
        $cart = Cart::getCart();

        if ($cart->payment) {
            return new JsonResource([
                'url'    => Payment::getRedirectUrl($cart),
                'status' =>$cart->payment->method == 'myfatoorah',
            ]);
        }
    }
    
    public function getCart()
    {
        return Cart::getCart();
    }
}