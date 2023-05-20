<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\Model;

use DI\Container;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderBurger;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderHotDog;
use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order\OrderSandwich;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;
use Nikcrazy37\Hw14\Libs\Request;

class OrderProcess
{
    private Container $container;
    private ?Ingredients $ingredients;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->request = new Request();
    }

    public function start()
    {
        $order = $this->container->get(OrderBurger::class)->addIngredients($this->ingredients)
            ->setNext($this->container->get(OrderHotDog::class))->addIngredients($this->ingredients)
            ->setNext($this->container->get(OrderSandwich::class))->addIngredients($this->ingredients);

        return $order->create($this->request->food);
    }

    public function addIngredients(?Ingredients $ingredients): static
    {
        $this->ingredients = $ingredients;
        return $this;
    }
}