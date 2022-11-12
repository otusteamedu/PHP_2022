<?php

declare(strict_types = 1);

namespace Validator;

class Validator
{
    /**
     * Проверка строки на скобки.
     *
     * @param string $string
     *
     * @return bool
     */
    public function regexCheck(string $string): bool
    {
        $regex = '/^[^()]*+(((?>[^()]|(?1))*+)[^()]*+)++$/';
        if (preg_match($regex, $string)) {
            return true;
        }
        return false;
    }
}