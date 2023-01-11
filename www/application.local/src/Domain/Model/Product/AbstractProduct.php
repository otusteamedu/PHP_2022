<?php

declare(strict_types=1);

namespace app\Domain\Model\Product;

use app\Domain\Model\Ingredient\AbstractIngredient;
use app\Domain\ValueObject\ProductComposition;

abstract class AbstractProduct implements ProductInterface {
    protected string $name;
    protected int $price;
    protected ProductComposition $composition;

    /**
     * @return ProductComposition
     */
    public function getComposition(): ProductComposition
    {
        return $this->composition;
    }

    public function __construct() {
        $this->composition = new ProductComposition([]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AbstractProduct
    {
        return $this;
    }

    public function addIngredient(AbstractIngredient $ingredient): void
    {
        $this->composition->addIngredient($ingredient);
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

}
