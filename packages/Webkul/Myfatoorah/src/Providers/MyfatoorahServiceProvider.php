<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Webkul\Admin\Http\Controllers\Sales\RefundController as BaseRefundController;
use Webkul\Myfatoorah\Http\Controllers\Sales\RefundController;
use Webkul\Myfatoorah\Providers\EventServiceProvider;

class MyfatoorahServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')->group(__DIR__ . '/../Routes/route.php');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/shop/components', 'myfatoorah');
    
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'my_fatoorah');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'myfatoorah');

        $this->app->register(EventServiceProvider::class);

        $this->app->bind(BaseRefundController::class,RefundController::class);
    } 

    /** 
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/paymentmethods.php', 'payment_methods'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php', 'core'
        );
    }
}