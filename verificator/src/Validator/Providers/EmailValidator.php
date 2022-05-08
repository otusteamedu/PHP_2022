<?php

namespace App\Validator\Providers;

use App\Validator\Interfaces\ValidatorInterface;

class EmailValidator implements ValidatorInterface
{

    /**
     * validate
     *
     * @param  mixed $value
     * @return bool
     */
    public function validate(string $value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        [$user, $host] = explode('@', $value);

        if (!checkdnsrr($host, 'MX')) {
            return false;
        }

        return true;
    }
}