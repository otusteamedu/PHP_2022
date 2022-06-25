<?php

namespace App\Service\CookingFood\Ingredient;

class Ingredient implements IngredientInterface
{
    public function __construct(
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}