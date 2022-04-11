<?php

namespace KonstantinDmitrienko\App;

class Response
{
    public const CHANNEL_ADDED_MESSAGE = 'Channel successfully added.';
    public const SUCCESS_STATUS = 200;
    public const JSON_HEADER_NAME = 'content-type';
    public const JSON_HEADER_VALUE = 'application/json';

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
            header(self::JSON_HEADER_NAME . ': ' . self::JSON_HEADER_VALUE);
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
