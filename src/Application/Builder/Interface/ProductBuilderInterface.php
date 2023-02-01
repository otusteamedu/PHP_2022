<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Builder\Interface;

use DKozlov\Otus\Domain\Model\Exception\ProductIngredientsNotFoundException;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Value\AbstractIngredient;

interface ProductBuilderInterface
{
    /**
     * @throws ProductIngredientsNotFoundException
     */
    public function cook(): ProductInterface;

    public function addIngredient(AbstractIngredient $ingredient): void;

    /**
     * @throws ProductIngredientsNotFoundException
     */
    public function cookByReceipt(): ProductInterface;
}