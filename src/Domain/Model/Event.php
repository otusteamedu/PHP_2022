<?php

namespace App\Domain\Model;

use JetBrains\PhpStorm\ArrayShape;

class Event
{
    private string $event;
    private int $priority;
    private array $conditions = [];


    public function __construct(string $event = '', int $priority = 0, array $conditions = [])
    {
        $this->event = $event;
        $this->priority = $priority;
        $this->conditions = $conditions;
    }


    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }


    /**
     * @param array $conditions
     *
     * @return Event
     */
    public function setConditions(array $conditions): Event
    {
        $this->conditions = $conditions;

        return $this;
    }


    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }


    /**
     * @param string $event
     *
     * @return Event
     */
    public function setEvent(string $event): Event
    {
        $this->event = $event;

        return $this;
    }


    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }


    /**
     * @param int $priority
     *
     * @return Event
     */
    public function setPriority(int $priority): Event
    {
        $this->priority = $priority;

        return $this;
    }


    #[ArrayShape(['event' => "string", 'priority' => "int", 'conditions' => "array"])]
    public function toArray(): array
    {
        return [
            'event' => $this->getEvent(),
            'priority' => $this->getPriority(),
            'conditions' => $this->getConditions(),
        ];
    }

}
