<?php

namespace App\Service\CookFood\Ingredient;

interface IngredientInterface
{
    public function getName(): string;

    public function setName(string $name): void;
}