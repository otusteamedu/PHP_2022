<?php

use Src\Sandwich\Infrastructure\Events\{
    BurgerIsReady,
    BurgerRecycled,
    HotDogIsReady,
    HotDogRecycled,
    SandwichIsReady,
    SandwichRecycled
};
use Src\Sandwich\Application\CookingProcess;
use Src\Sandwich\Domain\UseCases\BasicProductFactory;
use Src\Sandwich\Application\Observers\CookingObserver;
use Src\Sandwich\Application\Proxy\CookingProcessProxy;
use Src\Sandwich\Domain\Contracts\Events\CookingTraceability;
use Src\Sandwich\Domain\Entities\BasicProducts\{Burger, HotDog, Sandwich};
use Src\Sandwich\Domain\UseCases\Recipes\{HotDogRecipe, SandwichRecipe, BurgerRecipe};
use Src\Sandwich\Domain\UseCases\Cooking\{BurgerDecorator, HotDogDecorator, SandwichDecorator};
use Src\Sandwich\Domain\Entities\Ingredients\{BaconIngredient, OnionIngredient, TomatoIngredient};

use function DI\autowire;

return [
    CookingProcess::class => autowire(className: CookingProcess::class),

    CookingProcessProxy::class => autowire(className: CookingProcessProxy::class),

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
    'SandwichRecycled' => autowire(className: SandwichRecycled::class),
];
