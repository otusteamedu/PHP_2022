<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Decorator;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Observer\DishStateObserver;
use Cookapp\Php\Domain\State\StateInterface;

/**
 * Perpper ingredient
 */
class Pepper extends DishDecorator
{
    /**
     * @param AbstractDish $dish
     * @param string $description
     * @param int $price
     */
    public function __construct(private AbstractDish $dish, protected string $description = 'Перец', protected int $price = 20)
    {
    }

    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function attach(DishStateObserver $observer): void
    {
        $this->dish->attach($observer);
    }

    /**
     * @param DishStateObserver $observer
     * @return void
     */
    public function detach(DishStateObserver $observer): void
    {
        $this->dish->detach($observer);
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        $this->dish->notify();
    }

    /**
     * @param StateInterface $state
     * @return void
     */
    public function setState(StateInterface $state): void
    {
        $this->dish->setState($state);
    }

    /**
     * @return void
     */
    public function cook(): void
    {
        $this->dish->cook();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->dish->getDescription() . ' ' . $this->description;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->dish->getPrice() + $this->price;
    }
}
