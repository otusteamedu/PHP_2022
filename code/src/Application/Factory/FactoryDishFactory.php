<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Factory;

use Nikolai\Php\Domain\Factory\DishFactoryInterface;
use Nikolai\Php\Domain\Factory\FactoryDishFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class FactoryDishFactory implements FactoryDishFactoryInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function createDishFactory(string $dishName): DishFactoryInterface
    {
        if ($dishName === 'HotDog') {
            return new HotDogFactory($this->eventDispatcher);
        } elseif ($dishName === 'Burger') {
            return new BurgerFactory($this->eventDispatcher);
        } elseif ($dishName === 'Sandwich') {
            return new SandwichFactory($this->eventDispatcher);
        }
    }
}