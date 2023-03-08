<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Interfaces\Factories;

use SGakhramanov\Patterns\Interfaces\Observers\NotifierInterface;
use SGakhramanov\Patterns\Interfaces\Products\ProductInterface;

interface ProductsFactoryInterface
{
    public function makeBurger(NotifierInterface $notifier): ProductInterface;

    public function makeSandwich(NotifierInterface $notifier): ProductInterface;

    public function makeHotDog(NotifierInterface $notifier): ProductInterface;
}
