<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Sender;

use DKozlov\Otus\Domain\Sender\SenderInterface;
use DKozlov\Otus\Domain\Sender\SenderMessage;

class EmailSender implements SenderInterface
{
    public function send(SenderMessage $message): bool
    {
        echo 'Отправка письма на ' . $message->getTo() . ' с выпиской' . PHP_EOL;

        return mail($message->getTo(), $message->getSubject(), $message->getBody());
    }
}