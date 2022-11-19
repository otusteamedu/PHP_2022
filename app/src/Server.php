<?php

declare(strict_types=1);

namespace Eliasjump\UnixChat;

use Eliasjump\UnixChat\Socket\AppSocket;

class Server
{
    public function run()
    {
        $socket = new AppSocket();
        $socket->init();

        $socket->bind();
        $socket->listen();

        echo "Слушаю сокет:";
        while (true) {
            $socket->accept();
            echo $socket->read();
        }
    }
}