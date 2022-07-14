<?php

namespace Mselyatin\Project15\src\common\valueObjects;

use Assert\Assertion;
use DomainException;

/**
 * Class Color
 * @package Mselyatin\Project15\src\common\valueObjects
 */
class ColorHex
{
    /** @var string  */
    private string $value;

    /**
     * ColorHex constructor.
     * @param string $value
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(string $value)
    {
        $value = trim($value);
        Assertion::length($value, 7, 'HEX Цвет должен содержать 7 символов');
        if ($value[0] !== '#') {
            throw new DomainException('Невалидный HEX формат цвета');
        }

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