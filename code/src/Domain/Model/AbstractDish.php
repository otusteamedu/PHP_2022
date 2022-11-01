<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Model;

use SplObserver;
use SplSubject;

abstract class AbstractDish implements SplSubject
{
    private array $observers = [];

    public function attach(SplObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(SplObserver $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key) {
            unset($this->observers[$key]);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}