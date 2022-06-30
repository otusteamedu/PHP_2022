<?php

namespace App\Service;

use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    public static function create(string $message): AMQPMessage
    {
        return new AMQPMessage($message);
    }
}
