<?php

namespace App\Service\CookingFood\Event\Manager;

use SplSubject;

interface EventManagerInterface
{
    public function notify(array $observers, SplSubject $splSubject): void;
}