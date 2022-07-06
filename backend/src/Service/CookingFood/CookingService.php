<?php

namespace App\Service\CookingFood;

use App\Service\CookingFood\Cooking\CookingInterface;
use App\Service\CookingFood\Event\Manager\EventManagerInterface;
use App\Service\CookingFood\Event\StatusCookingEvent;
use App\Service\CookingFood\Exception\ProductValidationException;
use App\Service\CookingFood\Exception\RecipeNotFoundException;
use App\Service\CookingFood\Product\ProductFactory;
use App\Service\CookingFood\Product\ProductInterface;
use App\Service\CookingFood\Product\ProductRecipeDecorator;
use App\Service\CookingFood\Recipe\RecipeInterface;
use App\Service\CookingFood\Recipe\RecipeRepositoryInterface;
use App\Service\CookingFood\Request\AbstractRequest;
use SplObserver;

class CookingService
{
    private readonly StatusCookingEvent $startCookingEvent;
    private readonly StatusCookingEvent $endCookingEvent;

    public function __construct(
        private readonly CookingInterface          $cooking,
        private readonly AbstractRequest           $request,
        private readonly ProductFactory            $productFactory,
        private readonly RecipeRepositoryInterface $recipeRepository,
        EventManagerInterface                      $eventManager,
    )
    {
        $this->endCookingEvent = new StatusCookingEvent('End cooking', $eventManager);
        $this->startCookingEvent = new StatusCookingEvent('Start cooking', $eventManager);
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
        $this->startCookingEvent();
        $this->cooking($product);
        $this->endCookingEvent();
        return $product;
    }

    public function addStartCookingListener(SplObserver $observer): void
    {
        $this->startCookingEvent->attach($observer);
    }

    public function addEndCookingListener(SplObserver $observer): void
    {
        $this->endCookingEvent->attach($observer);
    }

    /**
     * @throws RecipeNotFoundException
     */
    private function getRecipe(): RecipeInterface
    {
        $productRecipeId = $this->request->getRecipeId();
        return $this->recipeRepository->getById($productRecipeId);
    }

    protected function startCookingEvent(): void
    {
        $this->startCookingEvent->notify();
    }

    protected function endCookingEvent(): void
    {
        $this->endCookingEvent->notify();
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