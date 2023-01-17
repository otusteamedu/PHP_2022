<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Service;

use HaydenPierce\ClassFinder\ClassFinder;
use Cookapp\Php\Application\Dto\DishDto;
use Cookapp\Php\Domain\Factory\FactoryDishFactoryInterface;
use Cookapp\Php\Domain\Factory\ObserverFactoryInterface;
use Cookapp\Php\Domain\Model\AbstractDish;

class CreateDishService
{
    private const OBSERVERS_NAMESPACE = 'Cookapp\Php\Application\Observer';

    public function __construct(
        private FactoryDishFactoryInterface $factoryDishFactory,
        private ObserverFactoryInterface $observerFactory
    ) {
    }

    public function createDish(DishDto $dishDto): AbstractDish
    {
        $dishFactory = $this->factoryDishFactory->createDishFactory($dishDto->dish);

        $dish = $dishFactory->createDish($dishDto->recipe);
        $dish = $this->attachObservers($dish, $dishDto->dish);

        if (!$dishDto->recipe) {
            foreach ($dishDto->ingredients as $ingredient) {
                $dish = $dishFactory->addIngredient($dish, $ingredient);
            }
        }

        return $dish;
    }

    private function attachObservers(AbstractDish $dish, string $nameDish): AbstractDish
    {
        $observerClasses = array_filter(
            ClassFinder::getClassesInNamespace(self::OBSERVERS_NAMESPACE, ClassFinder::RECURSIVE_MODE),
            function (string $class) use ($nameDish) {
                return str_contains($class, $nameDish);
            }
        );

        foreach ($observerClasses as $observerClass) {
            $observer = $this->observerFactory->createObserver($observerClass);
            $dish->attach($observer);
        }

        return $dish;
    }
}
