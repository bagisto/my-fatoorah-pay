<?php

use Illuminate\Support\Facades\Route;
use Webkul\Myfatoorah\Http\Controllers\Admin\MyfatoorahController;

Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin/myfatoorah'], function () {
    Route::controller(MyfatoorahController::class)->group(function () {
        Route::get('', 'index')->name('admin.myfatoorah.index');
    });
});