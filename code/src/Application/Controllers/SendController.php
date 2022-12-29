<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Services\SendService;

class SendController
{
    public function startSend()
    {
        SendService::startSendMessage();
    }
}