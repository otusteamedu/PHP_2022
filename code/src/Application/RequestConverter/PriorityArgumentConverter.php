<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\RequestConverter;

class PriorityArgumentConverter implements ConvertableInterface
{
    public function convert(string $argumentValue): int
    {
        return (int) $argumentValue;
    }
}