<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Model\Interface;

use DKozlov\Otus\Domain\Value\AbstractIngredient;
use DKozlov\Otus\Domain\Value\Interface\IngredientInterface;

interface ProductInterface
{
    public static function make(): self;

    public function addIngredient(IngredientInterface $ingredient): void;

    /**
     * @return IngredientInterface[]
     */
    public function getIngredients(): array;

    public function getProductReceipt(): AbstractIngredient;

    public function who(): string;
}