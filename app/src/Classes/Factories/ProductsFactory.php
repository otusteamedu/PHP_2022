<?php

namespace SGakhramanov\Patterns\Classes\Factories;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\BurgerInterface;
use SGakhramanov\Patterns\Interfaces\Products\HotDogInterface;
use SGakhramanov\Patterns\Interfaces\Products\SandwichInterface;
use SGakhramanov\Patterns\Interfaces\Factories\ProductsFactoryInterface;
use SGakhramanov\Patterns\Classes\Products\Burger;
use SGakhramanov\Patterns\Classes\Products\Sandwich;
use SGakhramanov\Patterns\Classes\Products\HotDog;

class ProductsFactory implements ProductsFactoryInterface
{
    public function makeBurger(NotifierInterface $notifier): BurgerInterface
    {
        return new Burger($notifier);
    }

    public function makeSandwich(NotifierInterface $notifier): SandwichInterface
    {
        return new Sandwich($notifier);
    }

    public function makeHotDog(NotifierInterface $notifier): HotDogInterface
    {
        return new HotDog($notifier);
    }
}
