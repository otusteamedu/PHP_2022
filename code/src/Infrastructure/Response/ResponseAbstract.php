<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * ResponseAbstract
 */
abstract class ResponseAbstract implements ResponseInterface
{
    /**
     * @return JsonResponse
     */
    public function send(string $id): JsonResponse
    {
        $response = new JsonResponse($this->messages, static::STATUS_CODE);
        $response->headers->set("x-id", $id);
        return $response->send();
    }
}
