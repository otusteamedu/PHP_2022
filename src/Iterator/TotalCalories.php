<?php

namespace Otus\Task14\Iterator;

use Otus\Task14\Decorator\Contract\IngredientInterface;

class TotalCalories
{

    public function __construct(
        private readonly IngredientInterface $ingredients,
    ){}

    public function get(): void
    {

        $sum = 0;
        $ingredients = $this->ingredients->createIterator();

        while ($ingredients->hasNext()){
            $sum += $ingredients->getNext()->getCalories();
        }

        echo 'Блюдо содержит: ' . $sum .' калорий'. PHP_EOL ;
    }
}