<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Services\SendService;

/**
 * Send request via form
 */
class SendController
{
    /**
     * Send request
     * @return void
     */
    public function startSend()
    {
        SendService::startSendMessage();
    }
}
