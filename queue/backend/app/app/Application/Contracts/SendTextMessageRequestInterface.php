<?php

namespace App\Application\Contracts;

interface SendTextMessageRequestInterface
{
    public function getReceiverCredentials(): string;

    public function getMessage(): string;
}
