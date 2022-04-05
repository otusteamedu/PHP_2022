<?php
/**
 * Description of RedisSimpleQueue.php
 * @copyright Copyright (c) MISTER.AM, LLC
 * @author    Egor Gerasimchuk <egor@mister.am>
 */

namespace App\Services\Queues;


use Redis;
use Illuminate\Redis\Connections\Connection;

final class RedisSimpleQueue implements SimpleQueue
{

    const QUEUE_PREFIX = 'simple_redis_queue:';

    private Redis $redis;

    public function __construct(
        Connection $redisConnection
    )
    {
        $this->redis = $redisConnection->client();
    }

    public function push(string $queue, string $data): void
    {
        $this->redis->lPush($this->generateKey($queue), $data);
    }

    public function pop(string $queue): ?string
    {
        $data = $this->redis->brPop($this->generateKey($queue), 5);
        if (!$data) {
            return null;
        }
        return $data;
    }

    private function generateKey(string $queue): string
    {
        return self::QUEUE_PREFIX . $queue;
    }

}
