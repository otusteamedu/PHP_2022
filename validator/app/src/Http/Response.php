<?php

namespace Otus\App\Http;

class Response
{
    public function create(string $message = '', int $code = 200): void
    {
        header('HTTP/1.1 ' . $code);
        echo $message;
    }
}