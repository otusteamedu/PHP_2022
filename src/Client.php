<?php

namespace AKhakhanova\Hw4;

class Client
{
    public function run()
    {
        $socket         = new UnixSocket();
        $socketFilePath = dirname(__FILE__) . "/client.sock";
        if (!$socket->create($socketFilePath)) {
            echo 'An error has occurred. Try again later';

            return;
        }

        $socket->setNonBlock();
        $server_side_sock = dirname(__FILE__) . "/server.sock";
        $msg              = "Message";
        $socket->sendTo($msg, $server_side_sock);
        $socket->setBlock();
        $socket->receiveFrom();
        $socket->close();
        $socket->unlink($socketFilePath);

        echo "Client exits\n";
    }
}
