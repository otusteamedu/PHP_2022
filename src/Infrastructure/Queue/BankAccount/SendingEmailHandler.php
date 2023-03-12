<?php

declare(strict_types=1);

namespace App\Infrastructure\Queue\BankAccount;

use App\Application\Queue\HandlerInterface;

class SendingEmailHandler implements HandlerInterface
{
    public function handle(SendingEmailMessage $message): void
    {
        // отправка email
    }
}