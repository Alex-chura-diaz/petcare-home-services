<?php

namespace App\Infrastructure\Events;

class InMemoryEventBus implements EventBus
{
    private array $listeners = [];

    public function publish(object $event): void
    {
        $eventClass = get_class($event);

        foreach ($this->listeners[$eventClass] ?? [] as $listener) {
            $listener($event);
        }
    }

    public function subscribe(string $eventClass, callable $listener): void
    {
        $this->listeners[$eventClass][] = $listener;
    }
}