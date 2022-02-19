<?php

const PARAMETER_NOT_FOUND_ERROR = 'Ошибка: Параметр string не найден.';
const STRING_IS_EMPTY_ERROR = 'Ошибка: Строка пуста.';
const IS_NOT_EQUAL_COUNT_ERROR = 'Ошибка: Количество "(" должно совпадать с ")".';
const INVALID_CHARACTERS_ERROR = 'Ошибка: В строке недопустимые символы.';
const VALIDATE_SUCCESS_MESSAGE = 'Строка валидна.';

const BAD_REQUEST_CODE = 400;

try {
    if (!array_key_exists('string', $_POST)) {
        throw new Exception(PARAMETER_NOT_FOUND_ERROR, BAD_REQUEST_CODE);
    }

    if (!$string = (string)$_POST['string']) {
        throw new Exception(STRING_IS_EMPTY_ERROR, BAD_REQUEST_CODE);
    }

    if (substr_count($string, '(') !== substr_count($string, ')')) {
        throw new Exception(IS_NOT_EQUAL_COUNT_ERROR, BAD_REQUEST_CODE);
    }

    if (!preg_match("/^\(+[(-)]+\)$/", $string)) {
        throw new Exception(INVALID_CHARACTERS_ERROR, BAD_REQUEST_CODE);
    }

    header('HTTP/1.1 200');
    echo VALIDATE_SUCCESS_MESSAGE;
} catch (Exception $e) {
    header('HTTP/1.1 ' . $e->getCode());
    echo $e->getMessage();
}
