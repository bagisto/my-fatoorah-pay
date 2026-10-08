<?php

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\PaymentController;

Route::group(['middleware' => ['locale', 'theme', 'currency']], function () {

    Route::controller(PaymentController::class)->group(function () {

        Route::get('myfatoorah', 'index');

        Route::get('myfatoorah/error', 'callBackError')->name('myfatoorah.error')->middleware('throttle:60,1');

        Route::get('myfatoorah/callback', 'callback')->name('myfatoorah.callback')->middleware('throttle:60,1');

        Route::get('myfatoorah/checkout', 'checkout')->name('myfatoorah.checkout');

        Route::post('myfatoorah/webhook', 'updateStatus')->name('myfatoorah.webhook')->middleware('throttle:240,1')->withoutMiddleware(ValidateCsrfToken::class);

        Route::get('myfatoorah/getMethods', 'getMethods')->name('myfatoorah.getMethods');
    });
});
