<?php

declare(strict_types=1);

namespace App\Application\Messenger\Common\Message;

/**
 * Сообщения, по которым будут отправляется уведомления в случае фэйлов.
 */
interface FailureNotificationMessageInterface
{
    public function getFailureMessage(): string;
}
