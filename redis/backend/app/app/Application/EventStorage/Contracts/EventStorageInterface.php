<?php

namespace App\Application\EventStorage\Contracts;

interface EventStorageInterface
{
    public function add(string $eventName, int $priority, array $params);

    public function clearAll();

    public function findEvent(array $params);
}
