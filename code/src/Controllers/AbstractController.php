<?php
declare(strict_types=1);


namespace Decole\Hw15\Controllers;


use Decole\Hw15\Core\Dtos\ServerErrorCode;
use Klein\Response;

class AbstractController
{
    protected function success(Response $response, array $body): void
    {
        $this->headers($response);
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
    }

    protected function error(Response $response, array $body, int $code = ServerErrorCode::BAD_REQUEST): void
    {
        $response->code($code);
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
        $this->headers($response);
    }

    private function headers(Response $response): void
    {
        $response->header('Content-Type', 'application/json');
        $response->header('Accept', '*/*');
    }
}