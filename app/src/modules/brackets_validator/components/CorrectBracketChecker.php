<?php

namespace nka\otus\modules\brackets_validator\components;

class CorrectBracketChecker
{
    /**
     * Сначала чистим строку от других символов,
     * затем проверяем на корректность, как регулярное выражение
     */
    public function check(string $string): bool
    {
        $result = false;
        $string = preg_replace('/[^()]/', '', $string);
        if (!empty($string)) {
            set_error_handler(function() {}, E_WARNING);
            $result = preg_match("/$string/", 'I love Otus') !== false;
            restore_error_handler();
        }
        return $result;
    }
}
