<?php

declare(strict_types=1);

namespace app\Domain\Model\Product\Hotdog;

class RestaurantHotdog extends AbstractHotdog {
    protected string $name = 'Хот-дог из ресторана';
    protected int $price = 20;
}
