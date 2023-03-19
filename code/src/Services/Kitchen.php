<?php

namespace Ppro\Hw20\Services;

use Ppro\Hw20\Products\ProductInterface;
use Ppro\Hw20\Recipes\RecipeStrategyInterface;

/** Реализует приготовление продукта
 *
 */
class Kitchen
{
    /**
     * @var ProductInterface
     */
    protected ProductInterface $product;

    /**
     * @param RecipeStrategyInterface $recipe
     */
    public function __construct(protected RecipeStrategyInterface $recipe)
    {
        $this->product = (new ($this->recipe->getProductFactory()))->create();
    }

    /** Приготовление продукта
     * @return void
     */
    public function productCook()
    {
        $this->product->setStatus('The kitchen has started cooking'.PHP_EOL);
        $this->product->productCook($this->recipe->getProcess());
        $this->product->setStatus('The kitchen has finished cooking'.PHP_EOL);
    }

    /**
     * @return ProductInterface
     */
    public function getProduct()
    {
        return $this->product;
    }
}