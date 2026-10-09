<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Webkul\Myfatoorah\Console\Commands\InstallMyfatoorah;
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

        $this->registerCommands();
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

        $this->publishes([
            __DIR__.'/../Resources/assets/images' => storage_path('app/public/myfatoorah'),
        ], 'public');

        Event::listen('sales.refund.save.after', [Refund::class, 'afterCreated']);
    }

    /**
     * Register the console commands of this package.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallMyfatoorah::class,
            ]);
        }
    }
}
