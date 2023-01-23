<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Domain;

class Event
{
    public function __construct(
        private string $name
    ) {
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
     * @return Event
     */
    public function setName(string $name): Event
    {
        $this->name = $name;
        return $this;
    }
}