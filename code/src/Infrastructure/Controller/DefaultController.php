<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Observer\BurgerObserver;
use Nikolai\Php\Application\Observer\BurgerObserver2;
use Nikolai\Php\Application\Observer\HotDogObserver;
use Nikolai\Php\Application\Observer\SandwichObserver;
use Nikolai\Php\Application\Strategy\BurgerCookingStrategy;
use Nikolai\Php\Application\Strategy\Cook;
use Nikolai\Php\Application\Strategy\HotDogCookingStrategy;
use Nikolai\Php\Application\Strategy\SandwichCookingStrategy;
use Nikolai\Php\Domain\Model\Burger;
use Nikolai\Php\Domain\Model\HotDog;
use Nikolai\Php\Domain\Model\Sandwich;

class DefaultController implements ControllerInterface
{
    public function __invoke($request)
    {
//        echo 'Не найден контроллер для команды: ' . $request->server->get('argv')[1] . PHP_EOL;

        $hotDog = new HotDog();
        $hotDogObserver = new HotDogObserver();
        $hotDog->attach($hotDogObserver);
        $hotDogCookingStrategy = new HotDogCookingStrategy($hotDog);
        $cook = new Cook($hotDogCookingStrategy);
        $cook->cook();

        $burger = new Burger();
        $burgerObserver = new BurgerObserver();
        $burgerObserver2 = new BurgerObserver2();
        $burger->attach($burgerObserver);
        $burger->attach($burgerObserver2);
        $burgerCookingStrategy = new BurgerCookingStrategy($burger);
        $cook = new Cook($burgerCookingStrategy);
        $cook->cook();

        $sandwich = new Sandwich();
        $sandwichObserver = new SandwichObserver();
        $sandwich->attach($sandwichObserver);
        $sandwichCookingStrategy = new SandwichCookingStrategy($sandwich);
        $cook = new Cook($sandwichCookingStrategy);
        $cook->cook();
    }
}