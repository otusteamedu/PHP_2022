<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Decorator;

use Cookapp\Php\Domain\Model\AbstractDish;
use Cookapp\Php\Domain\Observer\DishStateObserver;
use Cookapp\Php\Domain\State\StateInterface;

class Salad extends DishDecorator
{
    public function __construct(private AbstractDish $dish, protected string $description = 'Салат', protected int $price = 25)
    {
    }

    public function attach(DishStateObserver $observer): void
    {
        $this->dish->attach($observer);
    }

    public function detach(DishStateObserver $observer): void
    {
        $this->dish->detach($observer);
    }

    public function notify(): void
    {
        $this->dish->notify();
    }

    public function setState(StateInterface $state): void
    {
        $this->dish->setState($state);
    }

    public function cook(): void
    {
        $this->dish->cook();
    }

    public function getDescription(): string
    {
        return $this->dish->getDescription() . ' ' . $this->description;
    }

    public function getPrice(): int
    {
        return $this->dish->getPrice() + $this->price;
    }
}
