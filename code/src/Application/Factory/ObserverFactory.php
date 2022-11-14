<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Factory\ObserverFactoryInterface;
use Nikolai\Php\Domain\Observer\DishStateObserver;

class ObserverFactory implements ObserverFactoryInterface
{
    public function createObserver($class): DishStateObserver
    {
        return new $class();
    }
}