<?php

use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\PaymentController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {

    Route::controller(PaymentController::class)->group(function () {

        Route::get('myfatoorah', 'index');

        Route::get('myfatoorah/error', 'callBackError')->name('myfatoorah.error');

        Route::get('myfatoorah/callback', 'callback')->name('myfatoorah.callback');

        Route::get('myfatoorah/checkout', 'checkout')->name('myfatoorah.checkout');

        Route::post('myfatoorah/webhook', 'updateStatus')->name('myfatoorah.webhook');

        Route::get('myfatoorah/getMethods', 'getMethods')->name('myfatoorah.getMethods');

        Route::get('myfatoorah/getCartPayment', 'getCartpayment')->name('myfatoorah.getCartpayment');

        Route::post('myfatoorah/storeOrder', 'storeOrder')->name('myfatoorah.checkout.orders.store');

        Route::put('myfatoorah/cancelOrder', 'cancelOrder')->name('myfatoorah.checkout.orders.cancel');

        Route::get('myfatoorah/testApplePay', function(){
            return view('myfatoorah::shop.applePay');
        });
    });
});
