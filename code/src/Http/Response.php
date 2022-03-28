<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Http;

class Response
{
    /**
     * Коды ответа
     */
    public const CODE_SUCCESS = 200;
    public const CODE_ERROR = 400;

    /**
     * Установка кода ответа в зависимости от $result
     *
     * @param bool $result
     * @return void
     */
    public static function setCode(bool $result)
    {
        if ($result) {
            http_response_code(self::CODE_SUCCESS);
        } else {
            http_response_code(self::CODE_ERROR);
        }
    }
}
