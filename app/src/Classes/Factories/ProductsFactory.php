<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Classes\Factories;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;
use SGakhramanov\Patterns\Interfaces\Factories\ProductsFactoryInterface;
use SGakhramanov\Patterns\Classes\Products\Burger;
use SGakhramanov\Patterns\Classes\Products\Sandwich;
use SGakhramanov\Patterns\Classes\Products\HotDog;

class ProductsFactory implements ProductsFactoryInterface
{
    public function makeBurger(NotifierInterface $notifier): ProductInterface
    {
        return new Burger($notifier);
    }

    public function makeSandwich(NotifierInterface $notifier): ProductInterface
    {
        return new Sandwich($notifier);
    }

    public function makeHotDog(NotifierInterface $notifier): ProductInterface
    {
        return new HotDog($notifier);
    }
}
