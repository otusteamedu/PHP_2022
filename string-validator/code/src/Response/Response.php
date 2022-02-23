<?php

namespace KonstantinDmitrienko\StringValidator\Response;

class Response
{
    public static function emptyPost(): void
    {
        self::failureResponseCode();
        echo "Error: Required \"string\" parameter is empty.";
    }

    public static function success(): void
    {
        self::successResponseCode();
        echo "Success: String is valid.";
    }

    public static function failure(): void
    {
        self::failureResponseCode();
        echo "Error: Your string is invalid.";
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
