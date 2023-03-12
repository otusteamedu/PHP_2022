<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\BankAccount;

use App\Application\Queue\MessageInterface;

class TelegramNotificationMessage implements MessageInterface
{
    public function getHandlerClass(): string
    {
        return TelegramNotificationHandler::class;
    }
}