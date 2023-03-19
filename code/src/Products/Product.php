<?php

namespace Ppro\Hw20\Products;

use Ppro\Hw20\Actions\CookAction;
use Ppro\Hw20\Entity\DtoInterface;
use Ppro\Hw20\Entity\IngredientsDto;
use Ppro\Hw20\Entity\ProductDto;
use Ppro\Hw20\Observers\ProductPublisher;
use Ppro\Hw20\Recipes\RecipeStrategyInterface;

abstract class Product extends ProductPublisher implements ProductInterface
{
    /**
     * @var ProductDto
     */
    protected ProductDto $product;

    /**
     *
     */
    public function __construct()
    {
        $this->product = new ProductDto();
    }

    /**
     * @return ProductDto
     */
    public function getProductObject(): ProductDto
    {
        return $this->product;
    }

    /**
     * @param CookAction $cookAction
     * @return void
     */
    public function productCook(CookAction $cookAction): void
    {
        $cookAction->handle($this);
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->product->setStatus($status);
        $this->notify($this);
    }

    /**
     * @return void
     */
    public function utilizeProduct()
    {
        $this->product->utilize();
    }
}