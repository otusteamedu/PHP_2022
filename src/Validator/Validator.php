<?php

namespace App\Validator;

class Validator
{
    const BRACKETS = ['(', ')'];

    public function validate(string $value = ''): bool
    {
        $brackets = 0;

        $length = strlen($value);

        for ($i = 0; $i < $length; $i++) {
            if (!in_array($value[$i], self::BRACKETS)) {
                continue;
            }

            if ($value[$i] === '(') {
                $brackets++;
                continue;
            }

            if ($brackets < 1) {
                return false;
            }

            $brackets--;
        }

        return $brackets === 0;
    }
}
