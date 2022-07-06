<?php

namespace App\Service\CookFood\Event\Manager;

use SplSubject;

interface EventManagerInterface
{
    public function notify(array $observers, SplSubject $splSubject): void;
}