<?php

declare(strict_types=1);

namespace SGakhramanov\Patterns\Interfaces\Strategy;

interface MakeProductStrategyInterface
{
    public function makeProductByCalories(int $maxCalories);
}
