<?php

namespace Domain\Contract;

use Domain\ValueObject\MemoryStorageKey;

interface StorageInterface
{
    /**
     * @param MemoryStorageKey $memoryStorageKey
     * @return mixed
     */
    public function get(MemoryStorageKey $memoryStorageKey);

    /**
     * @param MemoryStorageKey $memoryStorageKey
     * @param $value
     */
    public function set(MemoryStorageKey $memoryStorageKey, $value): void;

    /**
     * @param MemoryStorageKey $memoryStorageKey
     */
    public function delete(MemoryStorageKey $memoryStorageKey): void;

    /**
     * Flushes all cached data
     */
    public function flush(): void;

    /**
     * @return void
     */
    public function recreateConnect(): void;
}