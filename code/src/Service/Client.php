<?php

namespace Study\Chat\Service;

use Study\Chat\Socket\UnixSocket;

class Client
{
    public function run()
    {
        $socket = new UnixSocket();

        echo "Здесь можно отправить сообщение в сокет:";
        while(true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;
            $socket->create();
            $socket->connect();
            $socket->write($message);
        }
    }
}