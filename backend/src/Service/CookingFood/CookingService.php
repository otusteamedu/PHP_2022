<?php

namespace App\Service\CookingFood;

use App\Service\CookingFood\Recipe\RecipeInterface;
use App\Service\CookingFood\Product\ProductFactory;
use App\Service\CookingFood\Request\AbstractRequest;
use App\Service\CookingFood\Product\ProductInterface;
use App\Service\CookingFood\Cooking\CookingInterface;
use App\Service\CookingFood\Product\ProductRecipeDecorator;
use App\Service\CookingFood\Recipe\RecipeRepositoryInterface;
use App\Service\CookingFood\Exception\RecipeNotFoundException;
use App\Service\CookingFood\Exception\ProductValidationException;

class CookingService
{
    public function __construct(
        private readonly CookingInterface          $cooking,
        private readonly AbstractRequest           $request,
        private readonly ProductFactory            $productFactory,
        private readonly RecipeRepositoryInterface $recipeRepository,
    )
    {
    }

    /**
     * @return ProductInterface
     * @throws RecipeNotFoundException
     * @throws ProductValidationException
     */
    public function makeProduct(): ProductInterface
    {
        $this->request->validation();
        $product = new ProductRecipeDecorator(
            $this->getProduct(), 
            $this->getRecipe(),
        );
        $this->cooking->cooking($product);
        return $product;
    }

    /**
     * @throws RecipeNotFoundException
     */
    private function getRecipe(): RecipeInterface
    {
        $productRecipeId = $this->request->getRecipeId();
        return $this->recipeRepository->getById($productRecipeId);
    }

    private function getProduct(): ProductInterface
    {
        $productType = $this->request->getProductType();
        return $this->productFactory->make($productType);
    }
}