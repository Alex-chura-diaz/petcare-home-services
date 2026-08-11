<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Events\EventBus;
use App\Infrastructure\Events\InMemoryEventBus;
use App\Domains\Reservas\Events\ReservaCreada;
use App\Domains\Reservas\Listeners\ReservaCreadaListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EventBus::class, function () {
        return new InMemoryEventBus();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         $eventBus = $this->app->make(EventBus::class);

         $eventBus->subscribe(
             ReservaCreada::class,
            [new ReservaCreadaListener(), 'handle']
         );

    }
}
