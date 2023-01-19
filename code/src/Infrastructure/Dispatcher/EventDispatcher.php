<?php

declare(strict_types=1);

namespace Cookapp\Php\Infrastructure\Dispatcher;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * EventDispatcher
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @param ListenerProviderInterface $listenerProvider
     */
    public function __construct(private ListenerProviderInterface $listenerProvider)
    {
    }

    /**
     * @param object $event
     * @return object
     */
    public function dispatch(object $event): object
    {
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }
        foreach ($this->listenerProvider->getListenersForEvent($event) as $listener) {
            $listener($event);
        }
        return $event;
    }
}
