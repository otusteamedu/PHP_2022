<?php

namespace App\Entity;

use JetBrains\PhpStorm\ArrayShape;

class Event
{
    private readonly int $id;

    private string $name;

    private int $priority;

    private string $event;

    private array $conditions = [];


    public function setId(int $id)
    {
        return $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getConditions(): ?array
    {
        return $this->conditions;
    }

    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function setCondition(string $name, string $value): self
    {
        $this->conditions[] = [$name => $value];
        return $this;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function toArray(): array
    {
        $event = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'priority' => $this->getPriority(),
        ];
        foreach ($this->getConditions() as $condition) {
            $event['conditions'][] = [
                'name' => $condition['name'],
                'value' => $condition['value'],
            ];
        }
        return $event;
    }
}
