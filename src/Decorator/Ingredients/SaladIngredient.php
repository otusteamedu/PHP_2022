<?php

namespace Otus\Task14\Decorator\Ingredients;

use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Decorator\IngredientDecorator;

class SaladIngredient extends IngredientDecorator
{

    public function getIngredient(): IngredientInterface
    {
       return $this->ingredient->getIngredient();
    }

    public function getName(): string
    {
        return 'Салат';
    }

    public function getCalories(): int
    {
        return 100;
    }

}