<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\RequestConverter;

class ConditionsArgumentConverter implements ConvertableInterface
{
    const CONDITION_DELIMITER = '.AND.';
    const VALUE_DELIMITER = ':';

    public function convert(string $argumentValue): array
    {
        $result = [];

        foreach (explode(self::CONDITION_DELIMITER, $argumentValue) as $item) {
            $value = explode(self::VALUE_DELIMITER, $item);
            $result[$value[0]] = $value[1];
        }

        return $result;
    }
}