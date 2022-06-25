<?php

namespace App\Service\CookingFood\Event;

use App\Service\CookingFood\Event\Manager\EventManagerInterface;
use SplSubject;

class StatusCookingEvent extends AbstractEvent implements SplSubject
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