<?php

declare(strict_types=1);

namespace Nikolai\Php\Converter;

abstract class AbstractTypePropertyConverter
{
    public function __construct(protected array $item) {}

    abstract function convert(): array;
}