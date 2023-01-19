<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Observer;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Observer\DishStateSubject;
use Cookapp\Php\Domain\Observer\DishStateObserver;

/**
 * Observerable
 */
class Observerable implements DishStateSubject
{
    private array $observers = [];

    /**
     * @param AbstractDish $dish
     */
    public function __construct(private AbstractDish $dish)
    {
    }

    /**
     * Attach state listener
     * @param DishStateObserver $observer
     * @return void
     */
    public function attach(DishStateObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * Deattach state listener
     * @param DishStateObserver $observer
     * @return void
     */
    public function detach(DishStateObserver $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key) {
            unset($this->observers[$key]);
        }
    }

    /**
     * Notify observers
     * @return void
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this->dish);
        }
    }
}
