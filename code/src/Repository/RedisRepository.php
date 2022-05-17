<?php

namespace App\Repository;

use Predis\ClientInterface;
use Redis;
use RedisArray;
use RedisCluster;
use Symfony\Component\Cache\Adapter\RedisAdapter;

/**
 * RedisRepository
 */
class RedisRepository
{
    /**
     * @var RedisArray|RedisCluster|ClientInterface
     */
    protected RedisArray|RedisCluster|ClientInterface $client;

    /**
     *   constructor
     */
    public function __construct()
    {
        $this->client = RedisAdapter::createConnection($_ENV['DNS_REDIS']);
    }

    /**
     * @param $key
     * @return false|mixed|\Redis|string|null
     */
    public function get($key): mixed
    {
        return $this->client->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function set($key, $value): void
    {
        $this->client->set($key, $value);
    }

    /**
     * @param $key
     * @return void
     */
    public function del($key): void
    {
        $this->client->del($key);
    }

    /**
     * @return array|Redis
     */
    public function getAll(): array|Redis
    {
        return $this->client->keys('*');
    }
}
