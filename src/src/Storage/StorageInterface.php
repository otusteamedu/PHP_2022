<?php

declare(strict_types=1);

namespace App\Storage;

use App\DataMapper\AbstractDataMapper;

interface StorageInterface
{
    public function testConnection(): string;

    public function getClientRepository(): AbstractDataMapper;
}
