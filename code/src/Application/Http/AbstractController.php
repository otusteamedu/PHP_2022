<?php
declare(strict_types=1);


namespace Decole\Hw18\Application\Http;


use Decole\Hw18\Application\Dto\ServerErrorCode;
use Klein\Response;

class AbstractController
{
    protected function success(Response $response, array $body): void
    {
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
    }

    protected function error(Response $response, array $body, int $code = ServerErrorCode::BAD_REQUEST): void
    {
        $response->code($code);
        $response->body(json_encode($body, JSON_THROW_ON_ERROR));
    }
}