<?php

namespace app\Domain\Model\Product;

use app\Domain\Model\Ingredient\AbstractIngredient;
use app\Domain\ValueObject\ProductComposition;

interface ProductInterface
{
    public function getComposition(): ProductComposition;
    public function getName(): string;
    public function setName(string $name): AbstractProduct;
    public function addIngredient(AbstractIngredient $ingredient): void;
    public function getPrice(): int;
}
