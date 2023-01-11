<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Burger;

class RestaurantBurger extends AbstractBurger {
    protected string $name = 'Бургер из ресторана';
    protected int $price = 10;
}
