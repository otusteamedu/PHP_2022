<?php

declare(strict_types=1);

namespace Svatel\Code\Client;

use Predis\Client;

final class RedisClient
{
    private Client $client;
    private const KEY = 'event';

    public function __construct()
    {
        $this->client = new Client(['host' => 'redis_otus']);

    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function add(array $conditions): bool
    {
        try {
            $this->client->zadd(
                self::KEY,
                $conditions
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getAll(): array
    {
        return $this->client->zrange(
            self::KEY,
            0,
            -1
        );
    }

    public function getOne(): array
    {
        return $this->client->zrevrangebyscore(
            self::KEY,
            '+inf',
            '-inf',
            ['withscores' => true]
        );
    }

    public function delete(): bool
    {
        try {
            $this->client->del(self::KEY);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
