<?php

namespace Otus\Task14\Decorator\Ingredients;

use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Decorator\IngredientDecorator;

class SauceIngredient extends IngredientDecorator
{

    public function getIngredient(): IngredientInterface
    {
       return $this->ingredient->getIngredient();
    }

    public function getName(): string
    {
        return 'Соус';
    }

    public function getCalories(): int
    {
        return 100;
    }

}