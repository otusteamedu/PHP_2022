<?php

declare(strict_types=1);

namespace Kogarkov\Validator\Core;

use Kogarkov\Validator\Model\ResponseModel;

class Response
{
    public function isOk(): void
    {
        $response = new ResponseModel(200, 'Everything is OK');
        print_r($response->getMessage());
    }

    public function isBad(string $message): void
    {
        $response = new ResponseModel(400, $message);
        http_response_code($response->getStatusCode());
        print_r($response->getMessage());
    }
}
