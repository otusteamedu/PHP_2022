<?php

declare(strict_types=1);

namespace App\Storage;

use App\DataMapper\AbstractDataMapper;
use App\Storage\PdoStorage\PdoStorage;
use RuntimeException;

class Storage implements StorageInterface
{
    private StorageInterface $storage;

    public function __construct(array $config)
    {
        $this->storage = match ($config['storage']) {
            'db' => new PdoStorage($config['database']),
            default => throw new RuntimeException('Invalid storage type'),
        };
    }

    public function getStorage(): StorageInterface
    {
        return $this->storage;
    }

    public function testConnection(): string
    {
        return $this->storage->testConnection();
    }

    public function getClientRepository(): AbstractDataMapper
    {
        return $this->storage->getClientRepository();
    }
}
