<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Storages;

interface StorageInterface
{
    public function add(array $conditions, string $event, int $score): void;

    public function get(array $conditions): string|null;

    public function truncate(): void;
}
