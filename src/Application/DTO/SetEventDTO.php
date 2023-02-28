<?php

namespace App\Application\DTO;

use App\Domain\Contract\SetEventDTOInterface;

class SetEventDTO implements SetEventDTOInterface
{
    private array $events;


    /**
     * @param array $events
     */
    public function __construct(array $events)
    {
        $this->events = $events;
    }


    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

}
