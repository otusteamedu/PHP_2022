<?php

namespace Otus\Task14\Decorator;

use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Iterator\CaloriesIterator;
use Otus\Task14\Iterator\Contract\CreateIteratorInterface;

abstract class IngredientDecorator implements IngredientInterface, CreateIteratorInterface
{
    public ?IngredientInterface $ingredient;

    public function __construct(?IngredientInterface $ingredient = null)
    {
        $this->ingredient = $ingredient ??  new IngredientComponent();
    }

    abstract function getIngredient(): IngredientInterface;
    public function createIterator(): CaloriesIterator
    {
        return new CaloriesIterator($this);
    }


}