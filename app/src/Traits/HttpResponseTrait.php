<?php

declare(strict_types=1);

namespace Octopus\App\Traits;

use Psr\Http\Message\ResponseInterface;

trait HttpResponseTrait
{
    private function successResponse(
        ResponseInterface $response,
    ): ResponseInterface {
        $message = [
            'success' => true,
        ];

        return $this->jsonResponse($response, $message);
    }

    private function errorResponse(
        ResponseInterface $response,
        string $message = '',
        int $errorCode = 0,
        $errorHttpStatus = 500
    ): ResponseInterface {
        $payload = [
            'success' => false,
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

    private function simpleSuccessResponse(array $data = []): string
    {
        $message = [
            'success' => true,
        ];

        if (!empty($data)) {
            $message['data'] = $data;
        }

        return json_encode($message);
    }

    private function simpleErrorResponse(array $data = []): string
    {
        $message = [
            'success' => false,
        ];

        if (!empty($data)) {
            $message['data'] = $data;
        }

        return json_encode($message);
    }
}
