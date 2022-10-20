<?php

namespace Onbalt\Validator;

class ValidateBrackets
{

    public function isValid(string $string): bool
    {
        if (!$string || preg_match('/[^()]+/', $string) !== 0) {
            return false;
        }

        $opened = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            $opened = $string[$i] === '(' ? $opened + 1 : $opened - 1;
            if ($opened < 0) {
                break;
            }
        }
        return $opened === 0;
    }
}