<?php

namespace App\Infrastructure\Events;

interface EventBus
{
    public function publish(object $event): void;

    public function subscribe(string $eventClass, callable $listener): void;
}