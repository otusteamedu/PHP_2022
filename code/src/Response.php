<?php

namespace KonstantinDmitrienko\App;

class Response
{
    /**
     * @param string $message
     *
     * @return void
     */
    public static function failure(string $message = ''): void
    {
        self::failureResponseCode();
        self::showMessage($message);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public static function success(string $message = ''): void
    {
        self::successResponseCode();
        self::showMessage($message);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    protected static function showMessage(string $message = ''): void
    {
        if ($message) {
            header('Content-Type: application/json; charset=utf-8');
            echo $message;
        }
    }

    /**
     * @return void
     */
    protected static function failureResponseCode(): void
    {
        http_response_code(400);
    }

    /**
     * @return void
     */
    protected static function successResponseCode(): void
    {
        http_response_code(200);
    }
}
