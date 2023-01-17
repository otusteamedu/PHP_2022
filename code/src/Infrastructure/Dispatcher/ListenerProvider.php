<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Dispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

class ListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    public function getListenersForEvent(object $event): iterable
    {
        $eventType = get_class($event);
        if (array_key_exists($eventType, $this->listeners)) {
            return $this->listeners[$eventType];
        }

        return [];
    }

    public function addListener(string $eventType, callable $callable): self
    {
        $this->listeners[$eventType][] = $callable;
        return $this;
    }

    public function clearListeners(string $eventType): void
    {
        if (array_key_exists($eventType, $this->listeners)) {
            unset($this->listeners[$eventType]);
        }
    }
}
