<?php

namespace App\Validator;

class Validator
{

    public function validate(string $value = ''): bool
    {
        $brackets = [];

        $length = strlen($value);

        for ($i = 0; $i < $length; $i++) {
            if ($value[$i] === '(') {
                $brackets[] = '(';
            }

            if ($value[$i] === ')') {
                if (!count($brackets)) {
                    return false;
                }

                array_shift($brackets);
            }
        }

        if (count($brackets)) {
            return false;
        }

        return true;
    }
}
