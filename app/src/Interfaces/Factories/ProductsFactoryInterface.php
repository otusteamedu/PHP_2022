<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Interfaces\Factories;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\BurgerInterface;
use SGakhramanov\Patterns\Interfaces\Products\SandwichInterface;
use SGakhramanov\Patterns\Interfaces\Products\HotDogInterface;

interface ProductsFactoryInterface
{
    public function makeBurger(NotifierInterface $notifier): BurgerInterface;

    public function makeSandwich(NotifierInterface $notifier): SandwichInterface;

    public function makeHotDog(NotifierInterface $notifier): HotDogInterface;
}
