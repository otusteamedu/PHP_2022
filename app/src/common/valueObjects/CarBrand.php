<?php

namespace Mselyatin\Project15\src\common\valueObjects;

use Assert\Assertion;

/**
 * Class CarBrand
 * @package Mselyatin\Project15\src\common\valueObjects
 */
class CarBrand
{
    /** @var string  */
    private string $value;

    /**
     * CarBrand constructor.
     * @param string $value
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(string $value)
    {
        Assertion::minLength($value, 2, 'Минимальная длина названия бренда должна быть 2 символа');
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    public static function create(string $value): self
    {
        return new self($value);
    }
}