<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order;

use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\AbstractOrder;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Order\Order;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Status\StatusEnum;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\Food;

class OrderBurger extends AbstractOrder
{
    /**
     * @param string $food
     * @return Order|null
     */
    public function create(string $food): ?Order
    {
        if ($food === "Burger") {
            $this->attach($this->observer);

            $recipe = $this->food->createRecipe();

            $burger = new Food($food, $recipe);

            $this->order = new Order($burger);
            $this->order->getStatus()->setValue(StatusEnum::COMPLETED);

            $this->notify();

            return $this->order;
        }

        return parent::create($food);
    }
}