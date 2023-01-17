<?php

namespace Redis\App\Repository\Factory;

use Redis\App\Repository\EventMemcachedRepository;
use Redis\App\Repository\EventRedisRepository;
use Redis\App\Repository\Repository;
use Redis\App\Trait\ContainerFactory;

class RepositoryFactory
{
    use ContainerFactory;

    private const REDIS_STORAGE_CODE = 'redis';
    private const MEMCACHED_STORAGE_CODE = 'memcached';
    private const STORAGE_MAP = [
        self::REDIS_STORAGE_CODE => EventRedisRepository::class,
        self::MEMCACHED_STORAGE_CODE => EventMemcachedRepository::class,
    ];

    public function create(): ?Repository
    {
        $storage = $_ENV['storage'];
        if (!array_key_exists($storage, self::STORAGE_MAP)) {
            return null;
        }

        return $this->getContainer()->get(self::STORAGE_MAP[$storage]);
    }
}