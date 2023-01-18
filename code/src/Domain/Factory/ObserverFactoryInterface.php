<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Factory;

use Cookapp\Php\Domain\Observer\DishStateObserver;

interface ObserverFactoryInterface
{
    public function createObserver($class, string $nameDish): DishStateObserver;
}
