<?php

declare(strict_types=1);

namespace App\Storage;

interface StorageInterface
{
    public function testConnection(): string;
}
