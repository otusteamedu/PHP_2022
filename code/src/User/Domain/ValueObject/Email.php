<?php

declare(strict_types=1);

namespace Kogarkov\Es\User\Domain\ValueObject;

class Email
{
    private $value;

    public function __construct(string $value)
    {
        $this->assertValidEmail($value);
        $this->value = $value;
    }

    private function assertValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Телефон должен содержать 10 цифр");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
