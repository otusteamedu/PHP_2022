<?php

declare(strict_types=1);

namespace Pinguk\RedisLearn\Service;

use RedisException;

class RedisService
{
    private \Redis $client;

    /**
     * @throws RedisException
     */
    public function __construct()
    {
        $this->client = new \Redis();
        $this->client->connect($_ENV['REDIS_HOST']);
    }

    /**
     * @throws RedisException
     */
    public function info(): void
    {
        print_r($this->client->info());
    }
}
