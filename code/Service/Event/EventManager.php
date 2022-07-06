<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\Event;
use App\Service\Storage\StorageInterface;

class EventManager
{
    public function __construct(private readonly StorageInterface $storage)
    {
    }

    public function save(Event $event): void
    {
        $this->storage->save($event);
    }

    public function findByParams(array $params): false|Event
    {
        return $this->storage->find($params);
    }

    public function clear(): void
    {
        $this->storage->clear();
    }
}