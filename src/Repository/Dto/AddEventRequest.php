<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Repository\Dto;

class AddEventRequest
{
    public function __construct(
        private readonly string $name,
        private readonly array $conditions,
        private readonly int $priority
    ) {
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}