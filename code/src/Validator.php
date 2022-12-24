<?php

declare(strict_types=1);

namespace Maldoshina\StringValidator;

class Validator
{
    /**
     * @param string|null $string
     *
     * @return bool
     */
    public function validateBrackets(?string $string): bool
    {
        if (!$string) {
            return false;
        }

        $counter = 0;
        foreach (str_split($string) as $symbol) {
            if ($symbol == '(') {
                $counter++;
            }

            if ($symbol == ')') {
                $counter--;
            }

            if ($counter < 0) {
                return false;
            }
        }

        return true;
    }
}