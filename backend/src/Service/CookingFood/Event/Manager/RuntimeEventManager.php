<?php

namespace App\Service\CookingFood\Event\Manager;

use SplSubject;

class RuntimeEventManager implements EventManagerInterface
{
    public function notify(array $observers, SplSubject $splSubject): void
    {
        foreach ($observers as $observer) {
            $observer->update($splSubject);
        }
    }
}