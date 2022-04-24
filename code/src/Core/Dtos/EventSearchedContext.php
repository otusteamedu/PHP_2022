<?php


namespace Decole\Hw13\Core\Dtos;


class EventSearchedContext
{
    public function __construct(
        private string $name,
        private int $priority,
        private array $condition,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getCondition(): array
    {
        return $this->condition;
    }
}