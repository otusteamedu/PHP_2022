<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Builder;

use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Domain\Model\Exception\ProductIngredientsNotFoundException;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Value\AbstractIngredient;

class ProductBuilder implements ProductBuilderInterface
{
    protected ProductInterface $product;

    protected ProductObserverInterface $observer;

    /**
     * @var AbstractIngredient[]
     */
    protected array $ingredients = [];

    public function __construct(
        ProductFactoryInterface $factory,
        ProductObserverInterface $observer,
        IngredientFactoryInterface $ingredientFactory
    ) {
        $this->product = $factory->make($ingredientFactory);
        $this->observer = $observer;
    }

    public function cookByReceipt(): ProductInterface
    {
        $this->addIngredient($this->product->getProductReceipt());

        return $this->cook();
    }

    public function cook(): ProductInterface
    {
        $step = $this->makeCookChain();

        do {
            $this->product->addIngredient($step);
            $this->observer->notify($this->product);
        } while ($step = $step->getNextIngredient());

        return $this->product;
    }

    public function addIngredient(AbstractIngredient $ingredient): void
    {
        $this->ingredients[] = $ingredient;
    }

    /**
     * @throws ProductIngredientsNotFoundException
     */
    protected function makeCookChain(): AbstractIngredient
    {
        $start = array_shift($this->ingredients);

        if (is_null($start)) {
            throw new ProductIngredientsNotFoundException('Ингридиенты для "' . $this->product->who() . " не найдены");
        }

        $current = $start;

        while ($step = array_shift($this->ingredients)) {
            $current->setNextIngredient($step);
            $current = $step;
        }

        return $start;
    }
}