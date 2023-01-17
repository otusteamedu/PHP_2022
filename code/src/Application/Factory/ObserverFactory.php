<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Factory;

use Cookapp\Php\Domain\Factory\ObserverFactoryInterface;
use Cookapp\Php\Domain\Observer\DishStateObserver;

class ObserverFactory implements ObserverFactoryInterface
{
    public function createObserver($class): DishStateObserver
    {
        return new $class();
    }
}