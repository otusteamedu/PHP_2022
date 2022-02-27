<?php

namespace Decole\NginxBalanceApp\Core;

class Validator
{
    public function validateParentheses(?string $field): array
    {
        $validation = [
            'is_validated' => false,
            'message' => 'Parenthesis not valid!',
        ];

        if (!$field) {
            return $validation;
        }

        if ($this->validate($field)) {
            $validation['is_validated'] = true;
            $validation['message'] = 'validate successfully';

            return $validation;
        }

        return $validation;
    }

    private function validate(string $field):bool
    {
        for ($i = 1, $iMax = mb_strlen($field); $i <= $iMax; $i++) {
            $field = str_replace('()', '', $field);
        }

        return empty($field);
    }
}