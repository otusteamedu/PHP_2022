<?php

declare(strict_types=1);

namespace App\Entity;

use Ds\Map;

class Event
{
    private string $eventName;

    private int $priority;

    private Map $conditions;

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): void
    {
        $this->eventName = $eventName;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getConditions(): Map
    {
        return $this->conditions;
    }

    public function addCondition(string $paramName, $paramValue): Map
    {
        $this->conditions->put($paramName, $paramValue);

        return $this->conditions;
    }

    public function removeCondition(string $paramName): Map
    {
        $this->conditions->remove($paramName);

        return $this->conditions;
    }
}