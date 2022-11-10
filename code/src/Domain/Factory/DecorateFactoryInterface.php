<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Factory;

use Nikolai\Php\Domain\Decorator\DishDecorator;
use Nikolai\Php\Domain\Model\AbstractDish;

interface DecorateFactoryInterface
{
    public function decorate(AbstractDish|DishDecorator $dish, string $ingredientName): DishDecorator;
}