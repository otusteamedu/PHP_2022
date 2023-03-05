<?php

declare(strict_types=1);

namespace App\Application\OrderHandling;

abstract class BaseHandler implements OrderHandlerInterface
{
    protected OrderHandlerInterface $nextHandler;

    public function setNext(OrderHandlerInterface $handler = new DefaultHandler()): void
    {
        $this->nextHandler = $handler;
    }
}