<?php

declare(strict_types=1);

namespace App\App\Event;

/**
 * DTO события
 */
class Event
{
    /**
     * Важность события
     */
    public int $priority;

    /**
     * Название события
     */
    public string $event;

    /**
     * Критерии возникновения
     */
    public array $conditions;

    public function __construct(int $priority, string $event, array $conditions)
    {
        $this->priority = $priority;
        $this->event = $event;
        $this->conditions = $conditions;
    }
}