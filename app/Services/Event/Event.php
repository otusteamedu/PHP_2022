<?php

namespace Otus\Task11\App\Services\Event;

class Event
{
    public function __construct(private readonly string $eventType, private array $conditions, private readonly int $priority = 500){}

    public function send(): bool
    {
        return true;
    }


    public function getPriority() : int{
        return $this->priority;
    }

    public function getEventType(): string{
        return $this->eventType;
    }

    public function getConditions(): array{
        return $this->conditions;
        sort($this->conditions);
        $fn = fn($key, $value) => $key . '=' . $value;
        return array_map($fn, array_values($this->conditions), array_keys($this->conditions));
    }

    public function toJson(): string{
        return json_encode([
            'event' => $this->getEventType(),
            'priority' => $this->getPriority(),
            'condition' => $this->getConditions(),
        ]);
    }

}