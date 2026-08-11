<?php

namespace App\Infrastructure\Events;

use Illuminate\Support\Facades\Event;

class LaravelEventBus implements EventBus
{
    public function publish(object $event): void
    {
        Event::dispatch($event);
    }

    public function subscribe(string $eventClass, callable $listener): void
    {
        Event::listen($eventClass, $listener);
    }
}
