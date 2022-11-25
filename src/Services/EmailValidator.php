<?php

declare(strict_types=1);

namespace Pinguk\Validator\Services;

class EmailValidator
{
    public static function validateString(string $email): bool
    {
        return !!preg_match('/^([A-Za-z0-9]+@[A-Za-z]+\.[A-Za-z]+)$/', $email);
    }

    public static function validateMXRecord(string $email): bool
    {
        $hostname = explode('@', $email)[1];
        getmxrr($hostname, $hosts, $weights);

        return isset($hosts) && !empty($hosts);
    }
}
