<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Infrastructure\Response\ResponseException;
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

        $id = $_REQUEST['id'] ?? "0";
        $responseFailed = new ResponseException(['exception' => $message]);
        $responseFailed->send($id);
    }
}