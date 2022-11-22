<?php

declare(strict_types=1);

namespace Otus\App\Model;

use JsonException;

class Event
{
    public const KEY        = 'event';
    public const NAME       = 'name';
    public const PRIORITY   = 'priority';
    public const CONDITIONS = 'conditions';

    protected string $id;
    protected string $name;
    protected int    $priority;
    protected string $conditions;

    public function __construct(array $event)
    {
        $this->setId(uniqid(self::KEY, true));
        $this->setName($event['event']);
        $this->setPriority($event['priority']);
        $this->setConditions(json_encode($event['conditions'], JSON_THROW_ON_ERROR));
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getConditions(): string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): void
    {
        $this->conditions = $conditions;
    }

    public function getEventDataForMemcached(): string
    {
        return json_encode(value: [
            'event' => $this->name,
            'score' => $this->priority,
            'conditions' => $this->conditions
        ]);
    }

    public function getConditionsForMemcached(): string
    {
        return json_encode(value: ['conditions' => $this->conditions]);
    }

}
