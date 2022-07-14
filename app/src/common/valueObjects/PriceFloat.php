<?php

namespace Mselyatin\Project15\src\common\valueObjects;

use InvalidArgumentException;

/**
 * Class PriceFloat
 * @package Mselyatin\Project15\src\common\valueObjects
 */
class PriceFloat
{
    /** @var float  */
    private float $value;

    /**
     * PriceFloat constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException('Цена не должна быть меньше или равна нулю');
        }
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return static
     */
    public static function create(float $value): self
    {
        return new self($value);
    }
}