<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model\Adapter;

use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Model\Sandwich;
use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Interface\IngredientInterface;

class ButerAdapter implements ProductInterface
{
    public function __construct(
        private readonly Sandwich $sandwich
    ) {
    }

    public static function make(IngredientFactoryInterface $ingredientFactory): ProductInterface
    {
        return new static(Sandwich::make($ingredientFactory));
    }

    public function addIngredient(IngredientInterface $ingredient): void
    {
        $this->sandwich->addIngredient($ingredient);
    }

    public function getIngredients(): array
    {
        return $this->sandwich->getIngredients();
    }

    public function getProductReceipt(): AbstractIngredient
    {
        return $this->sandwich->getProductReceipt();
    }

    public function who(): string
    {
        return 'бутерброд';
    }
}