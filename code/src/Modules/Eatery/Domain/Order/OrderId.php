<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Domain\Order;

class OrderId
{
    private int $value;

    public function __construct()
    {
        $this->value = random_int(0, 100);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}