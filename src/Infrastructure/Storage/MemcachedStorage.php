<?php

namespace App\Infrastructure\Storage;

use App\Domain\Contract\CacheStorage;
use App\Domain\Contract\GetEventDTOInterface;
use App\Domain\Model\Event;

// Создал для видимости возможной подмены с помощью DI, реализовывать не стал
class MemcachedStorage implements CacheStorage
{

    public function find(GetEventDTOInterface $dto): ?Event
    {
        // TODO: Implement find() method.
    }


    public function save(Event $event): void
    {
        // TODO: Implement save() method.
    }


    public function clear(): void
    {
        // TODO: Implement clear() method.
    }
}
