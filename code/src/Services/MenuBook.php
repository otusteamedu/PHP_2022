<?php

namespace Ppro\Hw20\Services;

use Ppro\Hw20\Exceptions\AppException;
use Ppro\Hw20\Products\ProductFactoryInterface;
use Ppro\Hw20\Recipes\RecipeStrategyInterface;

/** Инициализирует приготовление заказанного продукта
 *
 */
class MenuBook
{
    private RecipeStrategyInterface $recipe;
    private ProductFactoryInterface $product;

    public function __construct(string $recipeClass, string $productClass, array $recipeSteps, private array $orderSets = array())
    {
        if (!class_exists($productClass))
            throw new AppException('Product not found');
        if (!class_exists($recipeClass))
            throw new AppException('Recipe not found');
        $this->product = new $productClass();
        if(empty($recipeSteps))
            throw new AppException('RecipeSteps not found');
        $this->recipe = new $recipeClass($this->product, $recipeSteps, $this->orderSets);

    }

    public function getRecipe(): RecipeStrategyInterface
    {
        return $this->recipe;
    }

    public function getReadyProduct(): ProductFactoryInterface
    {
        return $this->product;
    }
}