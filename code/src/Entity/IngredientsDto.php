<?php

namespace Ppro\Hw20\Entity;

use Ppro\Hw20\Products\ProductFactoryInterface;

class IngredientsDto implements DtoInterface
{
    private array $ingredients = [];
    public function __construct()
    {

    }

    public function setIngredients(array $ingredients): void
    {
        $this->ingredients = $ingredients;
    }


    public function getIngredients(array $ingredients): array
    {
        return $this->ingredients;
    }

}