<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Factory;

use Cookapp\Php\Domain\Factory\ObserverFactoryInterface;
use Cookapp\Php\Domain\Observer\DishStateObserver;
use HaydenPierce\ClassFinder\ClassFinder;
use Cookapp\Php\Application\Service\CreateDishService;

/**
 * Observer factory
 */
class ObserverFactory implements ObserverFactoryInterface
{
    /**
     * @param $class
     * @param string $nameDish
     * @return DishStateObserver
     * @throws \Exception
     */
    public function createObserver($class, string $nameDish): DishStateObserver
    {
        // check that observer class is valid
        $observerClasses = array_filter(
            ClassFinder::getClassesInNamespace(CreateDishService::OBSERVERS_NAMESPACE, ClassFinder::RECURSIVE_MODE),
            function (string $class) use ($nameDish) {
                return str_contains($class, $nameDish);
            }
        );

        if (!in_array($class, $observerClasses)) {
            throw new \Exception('Не корректный тип класса Наблюдателя: ' . $class);
        }

        return new $class();
    }
}
