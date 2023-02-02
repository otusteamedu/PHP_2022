<?php

declare(strict_types=1);

namespace DKozlov\Otus\Application\Factory;

use DKozlov\Otus\Domain\Factory\Interface\IngredientFactoryInterface;
use DKozlov\Otus\Application\Factory\Interface\ProductFactoryInterface;
use DKozlov\Otus\Domain\Model\Interface\ProductInterface;
use DKozlov\Otus\Domain\Model\Proxy\BurgerProxy;

class BurgerFactory implements ProductFactoryInterface
{
    public function make(IngredientFactoryInterface $ingredientFactory): ProductInterface
    {
        return BurgerProxy::make($ingredientFactory);
    }
}