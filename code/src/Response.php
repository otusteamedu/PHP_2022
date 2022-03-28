<?php

namespace KonstantinDmitrienko\App;

class Response
{
    public static function failure($message = ''): void
    {
        header('HTTP/1.0 400 Bad Request');

        if ($message) {
            echo $message;
        }
    }
}
