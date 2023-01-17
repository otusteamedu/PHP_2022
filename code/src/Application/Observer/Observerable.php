<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Observer;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Observer\DishStateSubject;
use Cookapp\Php\Domain\Observer\DishStateObserver;

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