<?php

namespace App\Service\CookFood\Event;

use App\Service\CookFood\Event\Manager\EventManagerInterface;
use RuntimeException;
use SplObserver;
use SplSubject;

abstract class AbstractEvent implements SplSubject
{
    protected array $observers = [];

    public function __construct(
        private readonly EventManagerInterface $eventManager
    )
    {
    }

    public function notify(): void
    {
        $this->eventManager->notify($this->observers, $this);
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * @throws RuntimeException
     */
    public function detach(SplObserver $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key === false) {
            $className = get_class($observer);
            throw new RuntimeException("Observer($className) not found");
        }
        unset($this->observers[$key]);
    }
}