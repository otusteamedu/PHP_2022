<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Factory;

use Nikolai\Php\Domain\Decorator\DishDecorator;
use Nikolai\Php\Domain\Model\AbstractDish;

abstract class AbstractDishFactory
{
    const NAMESPACE_INGREDIENT_CLASSES = 'Nikolai\Php\Domain\Decorator\\';

    abstract public function createDish(?string $description): AbstractDish;

    public function addIngredient(AbstractDish $dish, string $nameIngredient): DishDecorator
    {
        $classIngredient = self::NAMESPACE_INGREDIENT_CLASSES . $nameIngredient;
        if (!class_exists($classIngredient)) {
            throw new \Exception('Не найден класс ингредиента: ' . $nameIngredient);
        }

        return new $classIngredient($dish);
    }
}