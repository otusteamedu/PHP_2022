<?php

namespace Mselyatin\Patterns\domain\events;

use Mselyatin\Patterns\domain\interfaces\events\EventAfterInterface;
use Mselyatin\Patterns\domain\interfaces\events\EventBeforeInterface;
use Mselyatin\Patterns\domain\interfaces\events\EventDispatchInterface;
use Mselyatin\Patterns\domain\interfaces\events\EventExistsInterface;

class EventDispatch implements EventDispatchInterface
{
    /** @var array  */
    private array $eventsAfter = [];

    /** @var array  */
    private array $eventsBefore = [];

    /** @var array  */
    private array $params;

    /**
     * @param mixed ...$params
     */
    public function __construct(...$params)
    {
        $this->params = $params;
    }

    /**
     * @param EventAfterInterface $eventAfter
     * @return EventDispatchInterface
     */
    public function addAfterEvent(EventAfterInterface $eventAfter): EventDispatchInterface
    {
        if (!in_array($eventAfter, $this->eventsAfter)) {
            $this->eventsAfter[] = $eventAfter;
        }

        return $this;
    }

    /**
     * @param EventBeforeInterface $eventBefore
     * @return EventDispatchInterface
     */
    public function addBeforeEvent(EventBeforeInterface $eventBefore): EventDispatchInterface
    {
        if (!in_array($eventBefore, $this->eventsBefore)) {
            $this->eventsBefore[] = $eventBefore;
        }

        return $this;
    }

    /**
     * @return EventDispatchInterface
     */
    public function dispatchAfterEvents(): EventDispatchInterface
    {
        array_walk($this->eventsAfter, function ($event) {
            if ($event instanceof EventAfterInterface) {
                $event->after($this->params);
            }
        });

        return $this;
    }

    /**
     * @return EventDispatchInterface
     */
    public function dispatchBeforeEvents(): EventDispatchInterface
    {
        array_walk($this->eventsBefore, function ($event) {
            if ($event instanceof EventBeforeInterface) {
                $event->before($this->params);
            }
        });

        return $this;
    }
}