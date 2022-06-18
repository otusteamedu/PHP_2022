<?php

namespace Nsavelev\Hw4\Http\Controllers\StringValidator;

class StringValidatorManager
{
    /**
     * @param string $stringWithBrackets
     * @return bool
     */
    public function validateBrackets(string $stringWithBrackets): bool
    {
        $isStringValidate = false;

        $charsOfString = preg_split('//', $stringWithBrackets, -1, PREG_SPLIT_NO_EMPTY);

        $countOfClosedBrackets = 0;

        foreach ($charsOfString as $key => $char) {
            if ($key === 0 && $char === ')') {
                $countOfClosedBrackets = 1;
                break;
            }

            if ($char === '(') {
                ++ $countOfClosedBrackets;
            }

            if ($char === ')' && $countOfClosedBrackets >= 0) {
                -- $countOfClosedBrackets;
            }
        }

        if ($countOfClosedBrackets === 0) {
            $isStringValidate = true;
        }

        return $isStringValidate;
    }
}
