<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Builder;

use DKozlov\Otus\Application\Builder\Interface\ProductBuilderInterface;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Application\Observer\Interface\ProductObserverInterface;
use DKozlov\Otus\Domain\Model\Exception\ProductIngredientsNotFoundException;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Value\AbstractIngredient;

class ProductBuilder implements ProductBuilderInterface
{
    protected ProductInterface $product;

    protected ProductObserverInterface $observer;

    protected ?AbstractIngredient $firstStep = null;
    protected ?AbstractIngredient $currentStep = null;

    public function __construct(ProductFactoryInterface $factory, ProductObserverInterface $observer)
    {
        $this->product = $factory->make();
        $this->observer = $observer;
    }

    public function cookByReceipt(): ProductInterface
    {
        $this->addIngredient($this->product->getProductReceipt());

        return $this->cook();
    }

    public function cook(): ProductInterface
    {
        $step = $this->firstStep;

        if (is_null($step)) {
            throw new ProductIngredientsNotFoundException('Ингридиенты для "' . $this->product->who() . " не найдены");
        }

        do {
            $this->product->addIngredient($step);
            $this->observer->notify($this->product);
        } while ($step = $step->getNextIngredient());

        return $this->product;
    }

    public function addIngredient(AbstractIngredient $ingredient): void
    {
        if (is_null($this->firstStep)) {
            $this->firstStep = $ingredient;
        } else {
            $this->currentStep->setNextIngredient($ingredient);
        }

        $this->currentStep = $ingredient;
    }
}