<?php

namespace TemaGo\PostRequestValidator;

class Response
{

    const HEADERS = [
        200 => "HTTP/1.1 200 OK",
        400 => "HTTP/1.1 400 Bad Request"
    ];

    public static function setHeader (int $code) : void
    {
        header(self::HEADERS[$code]);
    }

    public static function sendResponse ($message, $code = 200) : void
    {
        self::setHeader($code);
        echo $message;
    }
}
