<?php

namespace Otus\Task14\Decorator;


use Otus\Task14\Decorator\Contract\IngredientInterface;

class IngredientComponent implements IngredientInterface
{
    public function getIngredient(): IngredientInterface
    {
        return $this;
    }
}