<?php

namespace Email\App\Http;

class Response
{
    public function toJson(array $data = [], int $code = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}