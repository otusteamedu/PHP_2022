<?php

namespace Decole\Hw13\Controllers;

use Klein\Response;

class AbstractController
{
    protected function success(Response $response, array $body): void
    {
        $this->headers($response);
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
    }

    protected function error(Response $response, array $body): void
    {
        $response->code(400);
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
        $this->headers($response);
    }

    private function headers(Response $response): void
    {
        $response->header('Content-Type', 'application/json');
        $response->header('Accept', '*/*');
    }
}