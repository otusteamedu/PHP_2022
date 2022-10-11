<?php

namespace Nikolai\Php\Application\RequestConverter;

interface ConvertableInterface
{
    public function convert(string $argumentValue);
}