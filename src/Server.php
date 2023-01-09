<?php

namespace AKhakhanova\Hw4;

class Server
{
    public function run(): void
    {
        $socket = new UnixSocket();
        if (!$socket->create(dirname(__FILE__) . "/server.sock")) {
            echo 'An error has occurred. Try again later';

            return;
        }
        while (1) { // server never exits
            $socket->setBlock();
            echo "Ready to receive...\n";
            [$buf, $from] = $socket->getBytesReceivedInfo();
            echo "Received $buf from $from\n";

            $buf .= "->Response"; // process client query here

            $socket->setNonBlock();
            $socket->sendTo($buf, $from);

            echo "Request processed\n";
        }
    }
}
