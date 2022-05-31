<?php

declare(strict_types=1);

namespace App\Application\Decorator;

use App\Application\AbstractFactory\Contract\ProductInterface;
use App\Application\Decorator\Contract\DecoratorInterface;

abstract class ComponentDecorator implements DecoratorInterface
{
    /**
     * @var ProductInterface
     */
    protected ProductInterface $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function add(): ProductInterface
    {
        return $this->product->setIngredient($this->ingredient);
    }

    /**
     * @return string
     */
    public function getIngredient(): string
    {
        return $this->ingredient;
    }
}