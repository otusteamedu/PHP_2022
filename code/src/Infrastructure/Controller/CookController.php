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
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\Sandwich;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;

class CookController implements ControllerInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function __invoke(Request $request)
    {
        $hotDog = new HotDog();
        $hotDogObserver = new HotDogObserver();
        $hotDog->attach($hotDogObserver);
        $hotDogCookingStrategy = new HotDogCookingStrategy($hotDog);
        $cookProxy = new CookProxy($hotDogCookingStrategy, $this->eventDispatcher);
        $cookProxy->cook();

        $burger = new Burger();
        $burgerObserver = new BurgerObserver();
        $burgerObserver2 = new BurgerObserver2();
        $burger->attach($burgerObserver);
        $burger->attach($burgerObserver2);
        $burgerCookingStrategy = new BurgerCookingStrategy($burger);
        $cookProxy = new CookProxy($burgerCookingStrategy, $this->eventDispatcher);
        $cookProxy->cook();
/*
        $cook = new Cook($burgerCookingStrategy);
        $cook->cook();
*/

        $sandwich = new Sandwich();
        $sandwichObserver = new SandwichObserver();
        $sandwich->attach($sandwichObserver);
        $sandwichCookingStrategy = new SandwichCookingStrategy($sandwich);
        $cookProxy = new CookProxy($sandwichCookingStrategy, $this->eventDispatcher);
        $cookProxy->cook();

/*
        $cook = new Cook($sandwichCookingStrategy);
        $cook->cook();
*/
    }
}