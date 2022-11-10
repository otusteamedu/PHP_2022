<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Decorator\DishDecorator;
use Nikolai\Php\Domain\Decorator\Onion;
use Nikolai\Php\Domain\Decorator\Pepper;
use Nikolai\Php\Domain\Decorator\Salad;
use Nikolai\Php\Domain\Factory\DecorateFactoryInterface;
use Nikolai\Php\Domain\Model\AbstractDish;

class DecorateFactory implements DecorateFactoryInterface
{
    public function decorate(AbstractDish|DishDecorator $dish, string $ingredientName): DishDecorator
    {
        if ($ingredientName === 'Onion') {
            return new Onion($dish);
        } elseif ($ingredientName === 'Pepper') {
            return new Pepper($dish);
        } elseif ($ingredientName === 'Salad') {
            return new Salad($dish);
        }
    }
}