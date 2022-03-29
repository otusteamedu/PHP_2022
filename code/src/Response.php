<?php

namespace KonstantinDmitrienko\App;

class Response
{
    public static function failure($message = ''): void
    {
        self::failureResponseCode();

        if ($message) {
            echo $message;
        }
    }

    public static function success($message = ''): void
    {
        self::successResponseCode();

        if ($message) {
            echo $message;
        }
    }

    protected static function failureResponseCode(): void
    {
        http_response_code(400);
    }

    protected static function successResponseCode(): void
    {
        http_response_code(200);
    }
}
