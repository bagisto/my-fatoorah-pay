<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MyFatoorah\Library\MyFatoorah;
use MyFatoorah\Library\API\MyFatoorahRefund;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use Webkul\Admin\Http\Controllers\Sales\RefundController as BaseRefundController;
use Webkul\Myfatoorah\Commands\RegisterApplePay;
use Webkul\Myfatoorah\Http\Controllers\Sales\RefundController;

class MyfatoorahServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware('web')->group(__DIR__.'/../Routes/route.php');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/shop/components', 'myfatoorah');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'my_fatoorah');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'myfatoorah');

        $this->app->bind(BaseRefundController::class, RefundController::class);

        $this->registerConfig();

        $mfConfig = [
            'apiKey'      => core()->getConfigData('sales.payment_methods.myfatoorah.api_key'),
            'isTest'      => (bool) core()->getConfigData('sales.payment_methods.myfatoorah.test_mode'),
            'countryCode' => core()->getConfigData('sales.payment_methods.myfatoorah.country_iso'),
        ];

        $this->app->bind(MyFatoorah::class, function () use ($mfConfig) {
            return new MyFatoorah($mfConfig);
        });

        $this->app->bind(MyFatoorahPaymentEmbedded::class, function () use ($mfConfig) {
            return new MyFatoorahPaymentEmbedded($mfConfig);
        });

        $this->app->bind(MyFatoorahPayment::class, function () use ($mfConfig) {
            return new MyFatoorahPayment($mfConfig);
        });

        $this->app->bind(MyFatoorahRefund::class, function () use ($mfConfig) {
            return new MyFatoorahRefund($mfConfig);
        });

        $this->app->bind(myFatoorahPaymentStatus::class, function () use ($mfConfig) {
            return new myFatoorahPaymentStatus($mfConfig);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([RegisterApplePay::class]);
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        if((bool) core()->getConfigData('sales.payment_methods.myfatoorah.status')) {
            
            $this->mergeConfigFrom(
                dirname(__DIR__).'/Config/paymentmethods.php', 'payment_methods'
            );
        }

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php', 'core'
        );
    }
}
