<?php

use function DI\autowire;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Model\OrderProcess;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderBurger;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\AbstractOrder;

return [
    OrderProcess::class => autowire(className: OrderProcess::class),
    AbstractOrder::class => autowire(className: OrderBurger::class),

    /*CookingProcessProxy::class => autowire(className: CookingProcessProxy::class),

    BasicProductFactory::class => autowire(className: BasicProductFactory::class),

    CookingTraceability::class => autowire(className: CookingObserver::class),

    'BurgerRecipe' => autowire(className: BurgerRecipe::class),
    'HotDogRecipe' => autowire(className: HotDogRecipe::class),
    'SandwichRecipe' => autowire(className: SandwichRecipe::class),

    'OnionIngredient' => autowire(className: OnionIngredient::class),
    'TomatoIngredient' => autowire(className: TomatoIngredient::class),
    'BaconIngredient' => autowire(className: BaconIngredient::class),

    'Burger' => autowire(className: Burger::class),
    'HotDog' => autowire(className: HotDog::class),
    'Sandwich' => autowire(className: Sandwich::class),

    'BurgerDecorator' => autowire(className: BurgerDecorator::class),
    'HotDogDecorator' => autowire(className: HotDogDecorator::class),
    'SandwichDecorator' => autowire(className: SandwichDecorator::class),

    'BurgerIsReady' => autowire(className: BurgerIsReady::class),
    'HotDogIsReady' => autowire(className: HotDogIsReady::class),
    'SandwichIsReady' => autowire(className: SandwichIsReady::class),

    'BurgerRecycled' => autowire(className: BurgerRecycled::class),
    'HotDogRecycled' => autowire(className: HotDogRecycled::class),
    'SandwichRecycled' => autowire(className: SandwichRecycled::class),*/
];