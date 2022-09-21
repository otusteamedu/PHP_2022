<?php

namespace App\Application\Actions\TelegramMessage;

use App\Application\Actions\TelegramMessage\DTO\SendTextTelegramMessageRequest;
use App\Application\Actions\TelegramMessage\DTO\SendTextTelegramMessageResponse;
use App\Application\Contracts\SendTextTelegramMessageInterface;

class SendTextTelegramMessageAction
    implements SendTextTelegramMessageInterface
{
    public function send(SendTextTelegramMessageRequest $request): SendTextTelegramMessageResponse
    {
        return new SendTextTelegramMessageResponse();
    }
}
