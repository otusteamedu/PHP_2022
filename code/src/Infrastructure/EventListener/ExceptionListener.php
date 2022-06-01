<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Response\ResponseFailed;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $message = sprintf(
            '%s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        $responseFailed = new ResponseFailed(['exception' => $message]);
        $responseFailed->send();
    }
}