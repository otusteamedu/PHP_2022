<?php

namespace Otus\Task13\Product\Domain\ValueObject;

use Otus\Task13\Product\Domain\Exceptions\DomainErrorValidationException;

class ProductTitle
{
    public function __construct(private readonly ?string $value = null)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->value)) {
            throw new DomainErrorValidationException('Поле "Название" товара обязательно для заполнения');
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