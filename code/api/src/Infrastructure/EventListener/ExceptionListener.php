<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Api\Domain\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $response = new Response();
        $throwable = $event->getThrowable();
        $response->setContent(json_encode($throwable->getMessage(), JSON_UNESCAPED_UNICODE));

        if ($throwable instanceof EntityNotFoundException) {
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}