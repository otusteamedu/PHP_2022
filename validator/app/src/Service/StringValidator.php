<?php

namespace Otus\App\Service;

class StringValidator
{
    private const STRING_IS_EMPTY_ERROR = 'Ошибка: Строка пуста.';
    private const IS_NOT_EQUAL_COUNT_ERROR = 'Ошибка: Количество "(" должно совпадать с ")".';
    private const INVALID_CHARACTERS_ERROR = 'Ошибка: Недопустимые символы.';
    private const BAD_REQUEST_CODE = 400;

    /**
     * @throws \Exception
     */
    public function validate(string $string): void
    {
        if (!$string) {
            throw new \Exception(self::STRING_IS_EMPTY_ERROR, self::BAD_REQUEST_CODE);
        }

        if (substr_count($string, '(') !== substr_count($string, ')')) {
            throw new \Exception(self::IS_NOT_EQUAL_COUNT_ERROR, self::BAD_REQUEST_CODE);
        }

        if (!preg_match("/^\(+[(-)]+\)$/", $string)) {
            throw new \Exception(self::INVALID_CHARACTERS_ERROR, self::BAD_REQUEST_CODE);
        }
    }
}