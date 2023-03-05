<?php

declare(strict_types=1);

namespace App\Domain\Entity\Product;

use App\Domain\Enum\Ingredient;

abstract class BaseProduct implements ProductInterface
{
    /**
     * @var array<Ingredient>
     */
    protected array $ingredients;

    /**
     * @param array<Ingredient> $ingredients
     */
    public function __construct(array $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @inheritDoc
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}