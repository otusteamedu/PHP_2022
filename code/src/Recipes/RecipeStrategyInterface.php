<?php

namespace Ppro\Hw20\Recipes;

interface RecipeStrategyInterface
{
    public function getIngredients();
    public function getProcess();
    public function getProductFactory();
}