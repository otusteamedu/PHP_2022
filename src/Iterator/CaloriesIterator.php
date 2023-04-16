<?php

namespace Otus\Task14\Iterator;


use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Iterator\Contract\IteratorInterface;

class CaloriesIterator implements IteratorInterface
{
    public function __construct(
        private IngredientInterface $collection
    ){}

    public function getNext(): IngredientInterface
    {
       $collection = $this->collection;
       $this->collection = $this->collection->ingredient;
       return $collection;
    }

    public function hasNext(): bool
    {
        return property_exists($this->collection, 'ingredient');
    }


    public function getTotalCalories(): void
    {
        $sum = 0;
        while ($this->hasNext()){
            $sum += $this->getNext()->getCalories();
        }

        echo 'Блюдо содержит: ' . $sum .' калорий'. PHP_EOL ;
    }


}