<?php

namespace Otus\Mvc\Application\Services;

use Otus\Mvc\Application\Models\Entity\Producer\RaceSender;
use Otus\Mvc\Application\Viewer\View;

class SendService
{
    public function startSendMessage()
    {
        try {
            $send_message = new RaceSender();
            $send_message->generateMessage();
        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
    }
}