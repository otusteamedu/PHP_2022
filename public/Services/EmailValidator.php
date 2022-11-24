<?php

declare(strict_types=1);

class EmailValidator
{
    public static function validate(string $email): bool
    {
        $isValidString = preg_match('/^([A-Za-z0-9]+\@[A-Za-z]+\.[A-Za-z]+)$/', $email);

        if ($isValidString) {
            $hostname = explode('@', $email)[1];
            getmxrr($hostname, $hosts, $weights);

            if (isset($hosts) && !empty($hosts)) {
                return true;
            }
        }

        return false;
    }
}
