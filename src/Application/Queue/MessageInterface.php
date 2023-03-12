<?php

namespace App\Application\Queue;

interface MessageInterface
{
    public function getHandlerClass(): string;
}