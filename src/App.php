<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Http\Middleware\MiddlewareChain;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class App
{
    private MiddlewareChain $middleware;

    public function __construct()
    {
        $this->middleware = new MiddlewareChain();
    }

    public function run(ServerRequestInterface $request): void
    {
        $response = $this->middleware->handle($request);
        $this->sendResponse($response);
    }

    public function add(MiddlewareInterface $middleware): void
    {
        $this->middleware->add($middleware);
    }

    /**
     * Sends the response to the client.
     *
     * @param ResponseInterface $response
     */
    private function sendResponse(ResponseInterface $response): void
    {
        if (!headers_sent()) {
            header(
                sprintf(
                    'HTTP/%s %s %s',
                    $response->getProtocolVersion(),
                    $response->getStatusCode(),
                    $response->getReasonPhrase()
                ),
                true
            );

            foreach ($response->getHeaders() as $header => $values) {
                foreach ($values as $value) {
                    header(sprintf("%s: %s", $header, $value), false);
                }
            }
        }

        echo $response->getBody();
    }
}