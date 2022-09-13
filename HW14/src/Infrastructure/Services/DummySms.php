<?php

namespace App\Infrastructure\Services;

use App\Application\Contracts\SendMessageInterface;

class DummySms implements SendMessageInterface
{
    //Заглушка для отправки SMS
    public function sendMessage(string $text){
        echo "*SENDED SMS*: ".$text.PHP_EOL;
    }
}