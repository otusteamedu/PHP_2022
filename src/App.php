<?php

declare(strict_types=1);

namespace Pinguk\RedisLearn;

use Pinguk\RedisLearn\Service\RedisService;

class App
{
    private RedisService $redis;

    public function __construct()
    {
        $this->redis = new RedisService();
    }

    public function run(): void
    {
        $this->redis->info();
    }
}
