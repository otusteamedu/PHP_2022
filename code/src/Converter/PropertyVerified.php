<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

use Nikolai\Php\Exception\ConverterException;

class PropertyVerified implements PropertyVerifiedInterface
{
    public function __construct(private array $mappings) {}

    public function verifyNestedProperty($propertyName, $parentPropertyName): void {
        if (!array_key_exists($propertyName, $this->mappings[$parentPropertyName]["properties"])) {
            throw new ConverterException('Свойства: ' . $propertyName . ' нет в mapping-е индекса!');
        }
    }

    public function verify(string $propertyName): void
    {
        if (str_contains($propertyName, '.')) {
            $propertyNames = explode('.', $propertyName);
            $this->verify($propertyNames[0]);
            $this->verifyNestedProperty($propertyNames[1], $propertyNames[0]);
        } else {
            if (!array_key_exists($propertyName, $this->mappings)) {
                throw new ConverterException('Свойства: ' . $propertyName . ' нет в mapping-е индекса!');
            }
        }
    }
}