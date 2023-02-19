<?php

namespace Otus\Task13\Product\Domain\ValueObject;

class ProductId
{
    public function __construct(private readonly ?int $value = null)
    {
        $this->validate($value);
    }

    private function validate(?int $value): void
    {

    }

    public function getValue(): int
    {
        return $this->value;
    }


}