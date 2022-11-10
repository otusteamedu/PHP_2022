<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Application\Observer\BurgerObserver;
use Nikolai\Php\Application\Observer\BurgerObserver2;
use Nikolai\Php\Application\Proxy\CookProxy;
use Nikolai\Php\Application\Strategy\BurgerCookingStrategy;
use Nikolai\Php\Application\Strategy\Cook;
use Nikolai\Php\Domain\Factory\DishFactoryInterface;
use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\CookableInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class BurgerFactory implements DishFactoryInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(): AbstractDish
    {
        $dish = new Burger();
        $burgerObserver = new BurgerObserver();
        $burgerObserver2 = new BurgerObserver2();
        $dish->attach($burgerObserver);
        $dish->attach($burgerObserver2);

        return $dish;
    }

    public function createCookProxy(AbstractDish $dish): CookableInterface
    {
        $cookingStrategy = new BurgerCookingStrategy($dish);
        $cook = new Cook($cookingStrategy);
        return new CookProxy($cook, $this->eventDispatcher);
    }
}