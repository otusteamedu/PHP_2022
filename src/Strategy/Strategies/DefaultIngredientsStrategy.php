<?php

namespace Otus\Task14\Strategy\Strategies;

use Otus\Task14\Strategy\Contract\OrderStrategyInterface;

class DefaultIngredientsStrategy implements OrderStrategyInterface
{

    public function ingredients($product)
    {
        return $product->getDefaultIngredient();
    }
}