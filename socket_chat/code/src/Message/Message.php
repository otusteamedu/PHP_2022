<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\Message;

class Message
{
    public function showMessage(string $message)
    {
        echo trim($message) . PHP_EOL;
    }
}