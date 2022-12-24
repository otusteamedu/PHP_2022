<?php

namespace Study\Cinema\Model;

class Event
{

    const NAME = 'name';
    const PRIORITY = 'priority';
    const CONDITIONS = 'conditions';
    const KEY = 'event';
    /**
     * @var string
     */
    protected string $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var int
     */
    protected int    $priority;

    /**
     * @var string []
     */
    protected array $conditions;

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param array $conditions
     */
    public function setConditions(array $conditions): void
    {
        $this->conditions = $conditions;
    }
    public function __toString()
    {
        $conditions_string = json_encode($this->conditions);
        return "Event name: $this->name,  priority: $this->priority, conditions: $conditions_string";
    }

}