<?php

declare(strict_types=1);

namespace App\App\Elastic;

class RangeDTO
{
    public RangeCondition $condition;
    public mixed $value;

    public function __construct(RangeCondition $condition, mixed $value)
    {
        $this->condition = $condition;
        $this->value = $value;
    }
}