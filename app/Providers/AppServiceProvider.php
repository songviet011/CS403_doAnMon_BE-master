<?php

namespace App\Providers;

use App\Listeners\SePayWebhookListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use SePay\SePay\Events\SePayWebhookEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
        SePayWebhookEvent::class,
        [SePayWebhookListener::class, 'handle']
    );
    }
}
