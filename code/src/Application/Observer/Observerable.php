<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Observer;

use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Observer\DishStateSubject;
use Nikolai\Php\Domain\Observer\DishStateObserver;

class Observerable implements DishStateSubject
{
    private array $observers = [];

    public function __construct(private AbstractDish $dish) {}

    public function attach(DishStateObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(DishStateObserver $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key) {
            unset($this->observers[$key]);
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->dish);
        }
    }
}