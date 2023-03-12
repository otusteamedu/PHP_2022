<?php

namespace App\Application\Queue;

interface BusInterface
{
    public function dispatch(MessageInterface $message): void;
}