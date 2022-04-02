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
    public const CODE_404 = 404;

    /**
     * Отправка кода ответа
     *
     * @param bool|null $result
     * @param int|null  $code
     * @return void
     */
    public static function setResponseCode(?bool $result = null, ?int $code = null): void
    {
        http_response_code(self::defineCode($result, $code));
    }

    /**
     * Определение кода ответа
     *
     * @param bool|null $result
     * @param int|null  $code
     * @return int
     */
    private static function defineCode(?bool $result = null, ?int $code = null): int
    {
        if (!is_null($result)) {
            return ($result) ? self::CODE_SUCCESS : self::CODE_ERROR;
        } elseif (!is_null($code) && $code >= 100 && $code < 600) {
            return $code;
        } else {
            return self::CODE_404;
        }
    }
}
