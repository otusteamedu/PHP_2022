<?php
declare(strict_types=1);


namespace Decole\Hw18\Domain\Entity;


use Decole\Hw18\Domain\Entity\Product\ProductInterface;

class Dish
{
    public ProductInterface $baseProduct;

    public array $innerProducts = [];

    private DishWrapper $wrapper;

    public function setBaseProduct(ProductInterface $baseProduct): self
    {
        $this->baseProduct = $baseProduct;

        return $this;
    }

    public function setInnerProduct(InnerProduct $innerProduct): self
    {
        $this->innerProducts[] = $innerProduct;

        return $this;
    }

    public function setWrapper(DishWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
    }
}