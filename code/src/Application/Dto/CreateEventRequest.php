<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class CreateEventRequest
{
    public string $event;
    public int $priority;
    public ArrayCollection $conditions;

    public static function create(string $event, int $priority, array $conditions): self
    {
        $dto = new self();
        $dto->event = $event;
        $dto->priority = $priority;
        $dto->conditions = new ArrayCollection($conditions);

        return $dto;
    }
}