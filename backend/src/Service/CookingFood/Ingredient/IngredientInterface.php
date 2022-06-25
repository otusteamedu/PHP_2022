<?php

namespace App\Service\CookingFood\Ingredient;

interface IngredientInterface
{
    public function getName(): string;

    public function setName(string $name): void;
}