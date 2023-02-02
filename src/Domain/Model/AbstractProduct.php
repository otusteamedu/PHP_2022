<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model;

use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Value\Interface\IngredientInterface;

abstract class AbstractProduct implements ProductInterface
{
    protected array $ingredients = [];

    private function __construct(
        protected readonly IngredientFactoryInterface $ingredientFactory
    ) {
    }

    public static function make(IngredientFactoryInterface $ingredientFactory): ProductInterface
    {
        return new static($ingredientFactory);
    }

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }
}
