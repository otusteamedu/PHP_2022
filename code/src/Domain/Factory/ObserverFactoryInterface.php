<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Factory;

use Cookapp\Php\Domain\Observer\DishStateObserver;

/**
 * Observer factory interface
 */
interface ObserverFactoryInterface
{
    /**
     * @param $class
     * @param string $nameDish
     * @return DishStateObserver
     */
    public function createObserver(string $class, string $nameDish): DishStateObserver;
}
