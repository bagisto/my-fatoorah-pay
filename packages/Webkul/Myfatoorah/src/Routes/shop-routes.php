<?php

use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\PaymentController;

Route::controller(PaymentController::class)
    ->middleware('web')
    ->prefix('myfatoorah')
    ->group(function () {
        Route::get('redirect', 'redirect')->name('myfatoorah.redirect');

        Route::get('callback', 'callback')->name('myfatoorah.callback');

        Route::post('webhook', 'webhook')
            ->withoutMiddleware(PreventRequestForgery::class)
            ->name('myfatoorah.webhook');
    });
