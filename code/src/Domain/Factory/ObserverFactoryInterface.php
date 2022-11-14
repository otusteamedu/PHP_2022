<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Factory;

use Nikolai\Php\Domain\Observer\DishStateObserver;

interface ObserverFactoryInterface
{
    public function createObserver($class): DishStateObserver;
}