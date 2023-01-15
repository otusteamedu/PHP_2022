<?php

namespace Otus\App\Application\Services;

use Otus\App\Application\Entity\Producer\BankSender;
use Otus\App\Application\Viewer\View;

class SendService
{
    public static function startSendMessage()
    {
        try {
            $send_message = new BankSender();
            $send_message->generateMessage();
        } catch (\Exception $e) {
            View::render('error', [
                'title' => '503 - Service Unavailable',
                'error_code' => '503 - Service Unavailable',
                'result' => 'Cервер временно не имеет возможности обрабатывать запросы по техническим причинам'
            ]);
        }
        View::render('completed', [
            'title' => 'Заявка принята',
            'result' => 'Заявка принята'
        ]);
    }
}