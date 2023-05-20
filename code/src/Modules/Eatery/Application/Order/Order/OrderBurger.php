<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Application\Order\Order;

use Nikcrazy37\Hw14\Modules\Eatery\Application\Order\AbstractOrder;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Order\Order;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Status\StatusEnum;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\Food;
use DI\Container;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\FoodFactory;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\QualityFood;
use Nikcrazy37\Hw14\Modules\Eatery\Domain\Food\BurgerFood;
use Nikcrazy37\Hw14\Modules\Eatery\Infrastructure\DTO\Ingredients;

class OrderBurger extends AbstractOrder
{
    public function __construct(Container $container)
    {
        parent::__construct($container);

//        $this->food = $container->get(QualityFood::class);
//        $this->food->setFood(BurgerFood::class);
    }

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