<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Dispatcher;

use Psr\EventDispatcher\ListenerProviderInterface;

/**
 * ListenerProvider
 */
class ListenerProvider implements ListenerProviderInterface
{
    private array $listeners = [];

    /**
     * @param object $event
     * @return iterable
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventType = get_class($event);
        if (array_key_exists($eventType, $this->listeners)) {
            return $this->listeners[$eventType];
        }

        return [];
    }

    /**
     * @param string $eventType
     * @param callable $callable
     * @return $this
     */
    public function addListener(string $eventType, callable $callable): self
    {
        $this->listeners[$eventType][] = $callable;
        return $this;
    }

    /**
     * @param string $eventType
     * @return void
     */
    public function clearListeners(string $eventType): void
    {
        if (array_key_exists($eventType, $this->listeners)) {
            unset($this->listeners[$eventType]);
        }
    }
}
