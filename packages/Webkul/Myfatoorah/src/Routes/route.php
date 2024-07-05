<?php

use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\MyFatoorahController;

Route::controller(MyFatoorahController::class)->group(function () {
    
    Route::get('myfatoorah', 'index');
    
    Route::get('myfatoorah/error','callBackError')->name('myfatoorah.error');

    Route::get('myfatoorah/callback','callback')->name('myfatoorah.callback');
    
    Route::get('myfatoorah/checkout/{cartId}','checkout')->name('myfatoorah.checkout');
    
    Route::post('myfatoorah/webhook','webhook')->name('myfatoorah.webhook');
    
    Route::get('myfatoorah/redirect','redirect')->name('myfatoorah.redirect');
    
    Route::get('myfatoorah/getpaymentmethod/{cartId}','getPaymentMethods')->name('shop.checkout.onepage.myfatoorah.getpament.methods');
});
