<?php

namespace Otus\Task11\App\Services\Event\Drivers;

use Otus\Task11\App\Services\Event\Contracts\DriverContract;
use Otus\Task11\App\Services\Event\Event;
use Otus\Task11\Core\Container\Container;
use Otus\Task11\Core\Redis\RedisManager;

class RedisDriver implements DriverContract
{
    private readonly Container $container;
    private readonly RedisManager $redis;
    public function __construct()
    {
        $this->container = Container::instance();
        $this->redis = $this->container['redis'];
    }

    public function set(Event $event){
       $this->redis->zAdd('events', $event->getPriority(), $event->toJson());
    }

    public function get( array $conditions){
        $fn = fn($value) => json_decode($value, true);
        $events = array_map($fn, $this->redis->zRevRange('events', 0 , -1));
        foreach ($events as $event){
            foreach ($conditions as $key => $value ){
                if($event['condition'][$key] === $value)
                    return $event;
            }
        }

    }

    public function clean(){
        $this->redis->flushAll();
    }
}