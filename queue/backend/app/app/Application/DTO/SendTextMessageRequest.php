<?php

namespace App\Application\DTO;

use App\Application\Contracts\SendTextMessageRequestInterface;

class SendTextMessageRequest
    implements SendTextMessageRequestInterface
{
    private string $receiverCredentials;

    private string $message;

    public function __construct(string $receiverCredentials, string $message)
    {
        $this->receiverCredentials = $receiverCredentials;
        $this->message = $message;
    }

    public function getReceiverCredentials(): string
    {
        return $this->receiverCredentials;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
