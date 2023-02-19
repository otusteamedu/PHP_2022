<?php

namespace Otus\Task13\Product\Domain\ValueObject;

use Otus\Task13\Product\Domain\Exceptions\DomainErrorValidationException;

class ProductDescription
{
    public function __construct(private readonly ?string $value = null)
    {
        $this->assert($this->value);
    }

    private function assert(?string $value): void
    {
        if (empty($this->value)) {
            throw new DomainErrorValidationException('Поле "Описание" товара обязательно для заполнения');
        }
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}