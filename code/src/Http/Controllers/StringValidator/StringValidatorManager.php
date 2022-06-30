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

        foreach ($charsOfString as $char) {
            if ($char === '(') {
                ++ $countOfClosedBrackets;
            }

            if ($char === ')') {
                -- $countOfClosedBrackets;
            }

            if ($countOfClosedBrackets < 0) {
                break;
            }
        }

        if ($countOfClosedBrackets === 0) {
            $isStringValidate = true;
        }

        return $isStringValidate;
    }
}
