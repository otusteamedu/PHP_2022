<?php

declare(strict_types=1);

namespace App\Service\Event;

use App\Entity\Event;

class EventManager
{
    public function findByParams(array $params): Event
    {

    }

    public function save(Event $event): void
    {

    }

    public function clear(): void
    {

    }
}

//        $redis = new Redis();
//
//        $redis->connect($this->options['redis']['host']);