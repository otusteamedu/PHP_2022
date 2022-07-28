<?php

namespace Infrustructure\Storage;

use Domain\Contract\StorageInterface;
use Domain\ValueObject\MemoryStorageKey;
use Redis;

class RedisStorage implements StorageInterface
{
    public function get(MemoryStorageKey $memoryStorageKey)
    {
        // TODO: Implement get() method.
    }

    public function set(MemoryStorageKey $memoryStorageKey, $value): void
    {
        // TODO: Implement set() method.
    }

    public function delete(MemoryStorageKey $memoryStorageKey): void
    {
        // TODO: Implement delete() method.
    }

    public function flush(): void
    {
        // TODO: Implement flush() method.
    }

    public function recreateConnect(): void
    {
        // TODO: Implement recreateConnect() method.
    }
}