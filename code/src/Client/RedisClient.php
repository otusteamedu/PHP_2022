<?php

declare(strict_types=1);

namespace src\Client;

use Predis\Client;

final class RedisClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(['host' => 'redis_otus']);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}