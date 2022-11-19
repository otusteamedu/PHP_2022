<?php

declare(strict_types=1);

namespace Eliasjump\UnixChat;


use Eliasjump\UnixChat\Socket\AppSocket;

class Client
{
    public function run()
    {
        $socket = new AppSocket();

        echo "Можете отправить сообщение в сокет:";
        while(true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;
            $socket->init();
            $socket->connect();
            $socket->send($message);
        }
    }
}