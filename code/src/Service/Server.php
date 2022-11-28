<?php

namespace Study\Socket\Service;

use Study\Chat\Socket\UnixSocket;

class Server
{
    public function run()
    {
        $socket = new UnixSocket();
        $socket->create();
        $socket->bind();
        $socket->listen();

        echo "Сервер готов:";
        while (true) {
            $socket->accept();
            echo $socket->read();
        }
        $socket->close();
    }
}