<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms\Contracts;

interface Validation
{
    public static function validate(string $value): bool;
}
