<?php

namespace App\Application\Contracts;

use App\Application\Actions\EmailMessage\DTO\SendTextEmailMessageRequest;
use App\Application\Actions\EmailMessage\DTO\SendTextEmailMessageResponse;

interface SendTextEmailMessageInterface
{
    public function send(SendTextEmailMessageRequest $request): SendTextEmailMessageResponse;
}
