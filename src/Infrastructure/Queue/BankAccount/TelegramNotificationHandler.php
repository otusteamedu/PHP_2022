<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\BankAccount;

use App\Application\Queue\HandlerInterface;

class TelegramNotificationHandler implements HandlerInterface
{
    public function handle(TelegramNotificationMessage $message): void
    {
        // отправка оповещения в телегу
    }
}