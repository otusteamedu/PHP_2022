<?php

namespace Otus\Task14\Factory;

use Otus\Task14\Factory\Contract\ProductInterface;
use Otus\Task14\Decorator\Contract\IngredientInterface;
use Otus\Task14\Observer\Contract\SubjectInterface;

abstract class AbstractProduct implements ProductInterface
{
    protected ?IngredientInterface $ingredients = null;
    abstract protected function getDefaultIngredient(): IngredientInterface;

    public function setIngredients($ingredients){
        $this->ingredients = $ingredients;
    }
    public function getIngredients(): ?IngredientInterface
    {
       return $this->ingredients ?? $this->getDefaultIngredient();
    }
}