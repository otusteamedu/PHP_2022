<?php

declare(strict_types=1);

namespace Octopus\App\Storage\Interfaces;

interface StorageInterface
{
    public function add(array $params): void;

    public function get(array $params): string|null;

    public function truncate(): void;
}