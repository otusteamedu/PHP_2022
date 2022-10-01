<?php

namespace Nikolai\Php\Converter;

interface PropertyVerifiedInterface
{
    public function verify(string $propertyName): void;
}