<?php

namespace App\Listener;

use App\Product\ProductInterface;

class EventManager
{
    private array $listeners = [];

    public function subscribe(string $eventType, EventListenerInterface $listener)
    {
        $this->listeners[$eventType] ??= [];
        $this->listeners[$eventType][] = $listener;
    }

    public function unsubscribe(string $eventType, EventListenerInterface $listener)
    {
        $this->listeners[$eventType] ??= [];

        foreach ($this->listeners[$eventType] as $index => $addedListener) {
            if ($addedListener === $listener) {
                unset($this->listeners[$eventType][$index]);
            }
        }
    }

    public function event(string $eventType, ProductInterface $product)
    {
        $this->listeners[$eventType] ??= [];

        foreach ($this->listeners[$eventType] as $listener) {
            /** @var EventListenerInterface $listener */
            $listener->handle($product);
        }
    }
}
