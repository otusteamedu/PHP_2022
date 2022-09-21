<?php

namespace App\Application\Contracts;

use App\Application\Actions\TelegramMessage\DTO\SendTextTelegramMessageRequest;
use App\Application\Actions\TelegramMessage\DTO\SendTextTelegramMessageResponse;

interface SendTextTelegramMessageInterface
{
    public function send(SendTextTelegramMessageRequest $request): SendTextTelegramMessageResponse;
}
