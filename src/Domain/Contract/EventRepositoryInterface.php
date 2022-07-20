<?php

namespace App\Domain\Contract;

use App\Domain\Model\Event;

interface EventRepositoryInterface
{
    public function findByParams(GetEventDTOInterface $dto): ?Event;

    public function set(SetEventDTOInterface $dto): ?array;
}
