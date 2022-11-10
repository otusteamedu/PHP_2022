<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Application\Observer\HotDogObserver;
use Nikolai\Php\Application\Strategy\Cook;
use Nikolai\Php\Application\Proxy\CookProxy;
use Nikolai\Php\Application\Strategy\HotDogCookingStrategy;
use Nikolai\Php\Domain\Factory\DishFactoryInterface;
use Nikolai\Php\Domain\Model\AbstractDish;
use Nikolai\Php\Domain\Model\CookableInterface;
use Nikolai\Php\Domain\Model\HotDog;
use Psr\EventDispatcher\EventDispatcherInterface;

class HotDogFactory implements DishFactoryInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDish(): AbstractDish
    {
        $dish = new HotDog();
        $hotDogObserver = new HotDogObserver();
        $dish->attach($hotDogObserver);

        return $dish;
    }

    public function createCookProxy(AbstractDish $dish): CookableInterface
    {
        $cookingStrategy = new HotDogCookingStrategy($dish);
        $cook = new Cook($cookingStrategy);
        return new CookProxy($cook, $this->eventDispatcher);
    }
}