<?php

namespace Otus\Task14\Composite;

use Otus\Task14\Decorator\Contract\IngredientInterface;

class IngredientDish extends Dish
{
    public function __construct(
        private readonly IngredientInterface $ingredients,
    ){}

    public function collectTogether()
    {
        $ingredients = $this->ingredients->createIterator();
        while ($ingredients->hasNext()){
            $ingredient = $ingredients->getNext();
            echo '-- ' .  $ingredient->getName() . PHP_EOL;
        }
    }
}