<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MyFatoorah\Library\API\MyFatoorahRefund;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentEmbedded;
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use MyFatoorah\Library\MyFatoorah;
use Webkul\Myfatoorah\Commands\RegisterApplePay;
use Webkul\Myfatoorah\Listeners\Refund;
use Webkul\Myfatoorah\Payment\Myfatoorah as MyfatoorahPaymentMethod;

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

        Route::middleware('web', 'admin')->group(__DIR__.'/../Routes/admin-route.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/shop/components', 'myfatoorah');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'my_fatoorah');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'myfatoorah');

        Event::listen('sales.refund.save.after', [Refund::class, 'afterCreated']);

        $this->publishes([
            __DIR__.'/../Resources/views/shop/checkout/onepage/index.blade.php'   => resource_path('views/vendor/shop/checkout/onepage/index.blade.php'),
            __DIR__.'/../Resources/views/shop/checkout/onepage/payment.blade.php' => resource_path('views/vendor/shop/checkout/onepage/payment.blade.php'),
            __DIR__.'/../../publishable'                                          => public_path('themes/myfatoorah'),
        ]);

        if (
            ! $this->app->runningInConsole()
            && core()->getConfigData('sales.payment_methods.myfatoorah.api_key')
            && core()->getConfigData('sales.payment_methods.myfatoorah.register_apple_pay')
        ) {
            $this->mergeConfigFrom(
                dirname(__DIR__).'/Config/admin.php', 'menu.admin'
            );
        }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->bind(MyFatoorah::class, function () {
            return new MyFatoorah($this->app->make(MyfatoorahPaymentMethod::class)->getLibraryConfig());
        });

        $this->app->bind(MyFatoorahPaymentEmbedded::class, function () {
            return new MyFatoorahPaymentEmbedded($this->app->make(MyfatoorahPaymentMethod::class)->getLibraryConfig());
        });

        $this->app->bind(MyFatoorahPayment::class, function () {
            return new MyFatoorahPayment($this->app->make(MyfatoorahPaymentMethod::class)->getLibraryConfig());
        });

        $this->app->bind(MyFatoorahRefund::class, function () {
            return new MyFatoorahRefund($this->app->make(MyfatoorahPaymentMethod::class)->getLibraryConfig());
        });

        $this->app->bind(MyFatoorahPaymentStatus::class, function () {
            return new MyFatoorahPaymentStatus($this->app->make(MyfatoorahPaymentMethod::class)->getLibraryConfig());
        });
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

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/bagisto-vite.php', 'bagisto-vite.viters'
        );

        $this->commands([RegisterApplePay::class]);
    }
}
