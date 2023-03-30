<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

class Age
{
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
