<?php

use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\PaymentController;

Route::group(['prefix' => config('app.admin_url')], function () {

    Route::controller(PaymentController::class)->group(function () {
        
        Route::match(['get', 'post'],'myfatoorah/map-apple-pay', 'mapApplePay')->name('myfatoorah.settings.map-apple-pay');
    });
});
