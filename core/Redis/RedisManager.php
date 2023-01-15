<?php

namespace Otus\Task11\Core\Redis;

use Redis;
class RedisManager
{
    private Redis $redis;
    public function __construct(private readonly array $config)
    {
        $this->redis = new Redis();
        $this->redis->connect($this->config['host']);
    }

    public function getClient(): Redis{
        return $this->redis;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->redis->{$name}(...$arguments);
    }



}