<?php

declare(strict_types=1);

namespace App\Service\Storage;

use App\Entity\Event;

class MemcachedStorage implements StorageInterface
{

    public function find(array $params)
    {
        // TODO: Implement find() method.
    }

    public function save(Event $event)
    {
        // TODO: Implement save() method.
    }

    public function clear()
    {
        // TODO: Implement clear() method.
    }
}