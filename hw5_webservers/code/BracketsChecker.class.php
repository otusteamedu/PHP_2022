<?php

namespace Validator;

/**
 * Class for Otus HW #5
 */
class BracketsChecker
{
    /**
     * @param $string
     * @return bool
     */
    public function validateString($string): bool
    {
        if(!$string) {
            return false;
        }

        if(!$this->regExpBracketsCheck($string)) {
            return false;
        }

        return true;
    }

    /**
     * Check that string contain right brackets expression
     * @param string $string
     * @return bool
     */
    public function regExpBracketsCheck(string $string): bool
    {
        $regexp = '/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/';
        if (preg_match($regexp, $string)) {
            return true;
        }

        return false;
    }
}
