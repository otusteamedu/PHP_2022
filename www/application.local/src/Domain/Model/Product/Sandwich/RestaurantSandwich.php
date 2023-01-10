<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Sandwich;

class RestaurantSandwich extends AbstractSandwich {
    protected string $name = 'Сэндвич из ресторана';
    protected int $price = 30;
}
