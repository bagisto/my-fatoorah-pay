<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class MyfatoorahServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/route.php');
    
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'my_fatoorah');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'myfatoorah');

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
