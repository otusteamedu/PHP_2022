<?php

namespace App\Application\Contracts;

interface TextMessageTransportInterface
{
    public function send(SendTextMessageRequestInterface $request): void;
}
