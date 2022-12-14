<?php

namespace App\Application\Actions\EmailMessage;

use App\Application\Contracts\SendTextMessageRequestInterface;
use App\Application\Contracts\TextMessageTransportInterface;

class SendTextEmailMessageAction
    implements TextMessageTransportInterface
{
    public function send(SendTextMessageRequestInterface $request): string
    {
        return sprintf('Отправляем по email[%s]:' . PHP_EOL . '%s' . PHP_EOL,
            $request->getReceiverCredentials(),
            $request->getMessage()
        );
    }
}
