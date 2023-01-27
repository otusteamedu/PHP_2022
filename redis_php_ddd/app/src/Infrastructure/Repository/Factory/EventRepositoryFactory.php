<?php

namespace App\Ddd\Infrastructure\Repository\Factory;

use App\Ddd\Application\Repository;
use App\Ddd\Application\RepositoryFactory;
use App\Ddd\ContainerFactory;
use App\Ddd\Infrastructure\Repository\EventMemcachedRepository;
use App\Ddd\Infrastructure\Repository\EventRedisRepository;

class EventRepositoryFactory implements RepositoryFactory
{
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

        return ContainerFactory::getContainer()->get(self::STORAGE_MAP[$storage]);
    }
}