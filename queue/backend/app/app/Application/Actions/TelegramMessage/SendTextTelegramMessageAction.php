<?php

namespace App\Application\Actions\TelegramMessage;

use App\Application\Contracts\SendTextMessageRequestInterface;
use App\Application\Contracts\TextMessageTransportInterface;

class SendTextTelegramMessageAction
    implements TextMessageTransportInterface
{
    public function send(SendTextMessageRequestInterface $request): void
    {
        echo sprintf('Отправляем пользователю telegram[chat_id: %s]:' . PHP_EOL . '%s' . PHP_EOL,
            $request->getReceiverCredentials(),
            $request->getMessage()
        );
    }
}
