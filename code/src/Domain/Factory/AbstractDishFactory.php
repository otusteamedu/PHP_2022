<?php

declare(strict_types=1);

namespace Cookapp\Php\Domain\Factory;

use Cookapp\Php\Domain\Decorator\DishDecorator;
use Cookapp\Php\Domain\Model\AbstractDish;

abstract class AbstractDishFactory
{
    const NAMESPACE_INGREDIENT_CLASSES = 'Cookapp\Php\Domain\Decorator\\';

    abstract public function createDish(?string $description): AbstractDish;

    public function addIngredient(AbstractDish $dish, string $nameIngredient): DishDecorator
    {
        $classIngredient = self::NAMESPACE_INGREDIENT_CLASSES . $nameIngredient;
        if (!class_exists($classIngredient)) {
            throw new \Exception('Ingredient class not found: ' . $nameIngredient);
        }

        return new $classIngredient($dish);
    }
}