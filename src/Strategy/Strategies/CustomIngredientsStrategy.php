<?php

namespace Otus\Task14\Strategy\Strategies;

use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Strategy\Contract\OrderStrategyInterface;

class CustomIngredientsStrategy implements OrderStrategyInterface
{

    public function __construct(
        private readonly IngredientInterface $ingredients,
    ){}

    public function ingredients($product): IngredientInterface
    {
        return $this->ingredients;
    }
}