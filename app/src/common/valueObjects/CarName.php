<?php

namespace Mselyatin\Project15\src\common\valueObjects;

use Assert\Assert;
use Assert\Assertion;

/**
 * Class CarName
 * @package Mselyatin\Project15\src\common\valueObjects
 */
class CarName
{
    /**
     * @var string
     */
    private string $value;

    /**
     * CarName constructor.
     * @param string $value
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(string $value)
    {
        Assertion::minLength($value, 4, 'Минимальная длина названия Автомобиля должна быть 4 символа');
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