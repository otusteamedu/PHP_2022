<?php

namespace App\Domain\Contract;

use App\Domain\Model\Event;

interface CacheStorage
{

    public function find(GetEventDTOInterface $dto): ?Event;

    public function save(Event $event): void;

    public function clear(): void;
}
