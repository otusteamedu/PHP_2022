<?php

namespace Otus\App\Http;

class Request
{
    private const PARAMETER_NOT_FOUND_ERROR = 'Ошибка: Параметр string не найден.';
    private const BAD_REQUEST_CODE = 400;

    /**
     * @throws \Exception
     */
    public function post(string $key): string
    {
        if (!array_key_exists('string', $_POST)) {
            throw new \Exception(self::PARAMETER_NOT_FOUND_ERROR, self::BAD_REQUEST_CODE);
        }

        return (string)$_POST[$key];
    }
}