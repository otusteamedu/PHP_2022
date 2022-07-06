<?php

namespace App\Listener;

use SplObserver;
use SplSubject;

class StatusCookingListener implements SplObserver
{
    public function update(SplSubject $subject): void
    {
        $subject->getStatus();
    }
}