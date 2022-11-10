<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Observer\BurgerObserver;
use Nikolai\Php\Application\Observer\BurgerObserver2;
use Nikolai\Php\Application\Observer\HotDogObserver;
use Nikolai\Php\Application\Observer\SandwichObserver;
use Nikolai\Php\Application\Proxy\CookProxy;
use Nikolai\Php\Application\Strategy\BurgerCookingStrategy;
use Nikolai\Php\Application\Strategy\Cook;
use Nikolai\Php\Application\Strategy\HotDogCookingStrategy;
use Nikolai\Php\Application\Strategy\SandwichCookingStrategy;
use Nikolai\Php\Domain\Decorator\Onion;
use Nikolai\Php\Domain\Factory\DecorateFactoryInterface;
use Nikolai\Php\Domain\Factory\FactoryDishFactoryInterface;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\Sandwich;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class CookController implements ControllerInterface
{
    public function __construct(
        private FactoryDishFactoryInterface $factoryDishFactory,
        private DecorateFactoryInterface $decorateFactory
    ) {}

    public function __invoke(Request $request)
    {
        $ingredientName = 'Onion';
        $dishName = 'HotDog';
        $dishFactory = $this->factoryDishFactory->createDishFactory($dishName);

        $dish = $dishFactory->createDish();

        $dish = $this->decorateFactory->decorate($dish, $ingredientName);
        $dish = $this->decorateFactory->decorate($dish, 'Pepper');

        var_dump($dish);
        $cookProxy = $dishFactory->createCookProxy($dish);
        $cookProxy->cook();

/*
        $hotDog = $dishFactory->createDish(); //new Onion(new HotDog());
        $hotDogObserver = new HotDogObserver();
        $hotDog->attach($hotDogObserver);
//        $hotDogCookingStrategy = $dishFactory->createCookingStrategy($hotDog); //new HotDogCookingStrategy($hotDog);
//        $cook = new Cook($hotDogCookingStrategy);
//        $cookProxy = new CookProxy($cook); //, $this->eventDispatcher);
        $cookProxy = $dishFactory->createCookProxy($hotDog);
        $cookProxy->cook();

        var_dump($hotDog->getPrice());
*/
/*
        $burger = new Burger();
        $burgerObserver = new BurgerObserver();
        $burgerObserver2 = new BurgerObserver2();
        $burger->attach($burgerObserver);
        $burger->attach($burgerObserver2);
        $burgerCookingStrategy = new BurgerCookingStrategy($burger);
        $cook = new Cook($burgerCookingStrategy);
        $cookProxy = new CookProxy($cook, $this->eventDispatcher);
        $cookProxy->cook();

        $sandwich = new Sandwich();
        $sandwichObserver = new SandwichObserver();
        $sandwich->attach($sandwichObserver);
        $sandwichCookingStrategy = new SandwichCookingStrategy($sandwich);
        $cook = new Cook($sandwichCookingStrategy);
        $cookProxy = new CookProxy($cook, $this->eventDispatcher);
        $cookProxy->cook();

/*
        $cook = new Cook($sandwichCookingStrategy);
        $cook->cook();
*/
    }
}