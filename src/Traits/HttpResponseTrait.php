<?php

namespace  App\Traits;

use Psr\Http\Message\ResponseInterface;

trait HttpResponseTrait
{
    private function successResponse(
        ResponseInterface $response,
    ): ResponseInterface {
        $payload = [
            'code' => 200,
            'message' => 'Ты молодец',
        ];
        return $this->jsonResponse($response, $payload);
    }

    private function errorResponse(
        ResponseInterface $response,
        string $message = '',
        int $errorCode = 0,
        $errorHttpStatus = 500
    ): ResponseInterface {
        $payload = [
            'code' => $errorCode,
            'message' => $message,
        ];

        $json = $this->jsonResponse($response, $payload);

        return $json->withStatus($errorHttpStatus);
    }

    private function jsonResponse(ResponseInterface $response, $data): ResponseInterface
    {
        $payload = json_encode($data);
        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
