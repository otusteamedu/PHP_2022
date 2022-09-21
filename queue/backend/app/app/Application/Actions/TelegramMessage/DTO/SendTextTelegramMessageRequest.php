<?php

namespace App\Application\Actions\TelegramMessage\DTO;

class SendTextTelegramMessageRequest
{
    private string $chatId;

    private string $message;

    public function __construct(string $chatId, string $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
