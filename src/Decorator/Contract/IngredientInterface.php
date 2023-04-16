<?php

namespace Otus\Task14\Decorator\Contract;

interface IngredientInterface
{
    public function getIngredient(): IngredientInterface;
}