<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Value
{
    private string $value;

    /**
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->assertValidValue($value);
        $this->value = $value;
    }

    private function assertValidValue(string $value): void
    {
        if (!preg_match(pattern: '/^[a-zA-Zа-яА-Я]+$/u', subject: $value)) {
            throw new \InvalidArgumentException("Value должен быть строкой");
        }
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
