<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\RequestConverter;

class EventArgumentConverter implements ConvertableInterface
{
    public function convert(string $argumentValue): string
    {
        return $argumentValue;
    }
}