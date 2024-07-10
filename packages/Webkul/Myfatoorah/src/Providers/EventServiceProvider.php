<?php

namespace Webkul\Myfatoorah\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('bagisto.shop.checkout.onepage.summary.mayfatoorah', function ($viewRenderEventManager) {

            $viewRenderEventManager->addTemplate('myfatoorah::shop.checkout.myfatoorah.payment.available-methods');
        });

    }
}
