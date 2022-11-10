<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Application\Observer\SandwichObserver;
use Nikolai\Php\Application\Proxy\CookProxy;
use Nikolai\Php\Application\Strategy\Cook;
use Nikolai\Php\Application\Strategy\SandwichCookingStrategy;
use Nikolai\Php\Domain\Factory\DishFactoryInterface;
use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\CookableInterface;
use Nikolai\Php\Domain\Model\Sandwich;
use Psr\EventDispatcher\EventDispatcherInterface;

class SandwichFactory implements DishFactoryInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(): AbstractDish
    {
        $dish = new Sandwich();
        $sandwichObserver = new SandwichObserver();
        $dish->attach($sandwichObserver);

        return $dish;
    }

    public function createCookProxy(AbstractDish $dish): CookableInterface
    {
        $cookingStrategy = new SandwichCookingStrategy($dish);
        $cook = new Cook($cookingStrategy);
        return new CookProxy($cook, $this->eventDispatcher);
    }
}