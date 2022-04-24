<?php

namespace Decole\Hw13\Core\Dtos;

use JsonException;

class EventAddDto
{
    public int $priority;

    public array $condition;

    public string $eventType;

    /**
     * @throws JsonException
     */
    public function getCondition(): string
    {
        return json_encode($this->condition, JSON_THROW_ON_ERROR);
    }
}