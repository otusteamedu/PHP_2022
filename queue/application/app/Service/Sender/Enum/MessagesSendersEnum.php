<?php

namespace App\Service\Sender\Enum;

use App\Service\Sender\ConsoleSender;
use App\Service\Sender\TelegramSender;

class MessagesSendersEnum
{
    public const MESSAGES_SENDERS = [
        TelegramSender::class,
        ConsoleSender::class,
    ];
}
