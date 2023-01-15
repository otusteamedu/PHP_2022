<?php

namespace Otus\Task11\App\Services\Event\Contracts;

use Otus\Task11\App\Services\Event\Event;

interface DriverContract
{
    public function set(Event $event);

    public function get( array $condition);

    public function clean();
}