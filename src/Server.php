<?php

namespace AKhakhanova\Hw4;

class Server
{
    public function run(): void
    {
        $socket = new UnixSocket();
        $socket->create(dirname(__FILE__) . "/server.sock");
        while (1) {
            $socket->setBlock();
            print_r("Ready to receive...");
            [$buf, $from] = $socket->receive();
            print_r("Received \"$buf\" from $from");
            $socket->setNonBlock();
            $socket->sendTo($buf, $from);
            print_r("Request processed");
        }
    }
}
