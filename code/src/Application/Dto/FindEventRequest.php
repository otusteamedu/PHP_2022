<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class FindEventRequest
{
    public ArrayCollection $conditions;

    public static function create(array $conditions): self
    {
        $dto = new self();
        $dto->conditions = new ArrayCollection($conditions);

        return $dto;
    }
}