<?php

namespace App\Service\CookFood;

use App\Service\CookFood\Cook\CookInterface;
use App\Service\CookFood\Event\Manager\EventManagerInterface;
use App\Service\CookFood\Event\StatusCookEvent;
use App\Service\CookFood\Exception\ProductValidationException;
use App\Service\CookFood\Exception\RecipeNotFoundException;
use App\Service\CookFood\Product\ProductFactory;
use App\Service\CookFood\Product\ProductInterface;
use App\Service\CookFood\Product\ProductRecipeDecorator;
use App\Service\CookFood\Recipe\RecipeInterface;
use App\Service\CookFood\Recipe\RecipeRepositoryInterface;
use App\Service\CookFood\Request\AbstractRequest;
use SplObserver;

class CookService
{
    private readonly StatusCookEvent $startCookEvent;
    private readonly StatusCookEvent $endCookEvent;

    public function __construct(
        private readonly CookInterface             $cooking,
        private readonly AbstractRequest           $request,
        private readonly ProductFactory            $productFactory,
        private readonly RecipeRepositoryInterface $recipeRepository,
        EventManagerInterface                      $eventManager,
    )
    {
        $this->endCookEvent = new StatusCookEvent('End cooking', $eventManager);
        $this->startCookEvent = new StatusCookEvent('Start cooking', $eventManager);
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
        $this->startCookEvent();
        $this->cooking($product);
        $this->endCookEvent();
        return $product;
    }

    public function addStartCookListener(SplObserver $observer): void
    {
        $this->startCookEvent->attach($observer);
    }

    public function addEndCookListener(SplObserver $observer): void
    {
        $this->endCookEvent->attach($observer);
    }

    /**
     * @throws RecipeNotFoundException
     */
    private function getRecipe(): RecipeInterface
    {
        $productRecipeId = $this->request->getRecipeId();
        return $this->recipeRepository->getById($productRecipeId);
    }

    protected function startCookEvent(): void
    {
        $this->startCookEvent->notify();
    }

    protected function endCookEvent(): void
    {
        $this->endCookEvent->notify();
    }

    protected function cooking(ProductInterface $product): void
    {
        $this->cooking->cooking($product);
    }

    private function getProduct(): ProductInterface
    {
        $productType = $this->request->getProductType();
        return $this->productFactory->make($productType);
    }
}