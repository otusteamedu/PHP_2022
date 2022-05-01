<?php

namespace App\Ddd\Domain;

use JsonSerializable;

class Event implements Model, JsonSerializable
{
    public const NAME_FIELD = 'name';
    public const PRIORITY_FIELD = 'priority';
    public const CONDITIONS_FIELD = 'conditions';

    private string $id;
    private string $name;
    private int $priority;
    private string $conditions;
    
    public static function create(): self
    {
        return new self();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getConditions(): string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): self
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'priority' => $this->priority,
            'conditions' => json_decode($this->conditions),
        ];
    }

    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}
