<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Domain\Message;

class MessageBuilder
{
    public static function build(string $messageBody): Message
    {
        return new Message($messageBody);
    }
}
