<?php

namespace KonstantinDmitrienko\App;

class Response
{
    public static function failure($message = ''): void
    {
        self::failureResponseCode();
        self::showMessage($message);
    }

    public static function success($message = ''): void
    {
        self::successResponseCode();
        self::showMessage($message);
    }

    protected static function showMessage($message = ''): void
    {
        if ($message) {
            header('Content-Type: application/json; charset=utf-8');
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
