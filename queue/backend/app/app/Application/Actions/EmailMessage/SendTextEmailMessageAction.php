<?php

namespace App\Application\Actions\EmailMessage;

use App\Application\Actions\EmailMessage\DTO\SendTextEmailMessageRequest;
use App\Application\Actions\EmailMessage\DTO\SendTextEmailMessageResponse;
use App\Application\Contracts\SendTextEmailMessageInterface;

class SendTextEmailMessageAction
    implements SendTextEmailMessageInterface
{
    public function send(SendTextEmailMessageRequest $request): SendTextEmailMessageResponse
    {
        return new SendTextEmailMessageResponse();
    }
}
