<?php

namespace App\Service\CookFood\Event;

use App\Service\CookFood\Event\Manager\EventManagerInterface;
use SplSubject;

class StatusCookEvent extends AbstractEvent implements SplSubject
{
    public function __construct(
        private readonly string                $status,
        private readonly EventManagerInterface $eventManager
    )
    {
        parent::__construct($this->eventManager);
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}