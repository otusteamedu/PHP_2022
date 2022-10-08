<?php

declare(strict_types=1);

namespace App\SearchEngine\Validation\Services;

use App\SearchEngine\Mechanisms\Contracts\Validation;

final class PriceValidation implements Validation
{
    /**
     * @param string $value
     * @return bool
     */
    public static function validate(string $value): bool
    {
        preg_match(pattern: '/(^[0-9]*[.])?[0-9]+$/m', subject: $value, matches: $matches);

        return ! empty($matches[0]);
    }
}
