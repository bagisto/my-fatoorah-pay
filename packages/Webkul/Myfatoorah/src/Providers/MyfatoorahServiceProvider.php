<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Myfatoorah\Listeners\Refund;

class MyfatoorahServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__).'/Config/payment-methods.php', 'payment_methods');

        $this->mergeConfigFrom(dirname(__DIR__).'/Config/system.php', 'core');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/shop-routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'my_fatoorah');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'myfatoorah');

        Event::listen('sales.refund.save.after', [Refund::class, 'afterCreated']);
    }
}
