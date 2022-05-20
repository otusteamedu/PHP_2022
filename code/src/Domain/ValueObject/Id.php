<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class Id
{
    private string $value;

    /**
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->assertValidId($value);
        $this->value = $value;
    }

    private function assertValidId(string $value): void
    {
        if (!preg_match('/^\d.*$/', $value)) {
            throw new \InvalidArgumentException("ID должен содержать только цифры");
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
