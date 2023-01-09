<?php

namespace AKhakhanova\Hw4;

use Throwable;

class Client
{
    public function run(): void
    {
        try {
            $socket         = new UnixSocket();
            $socketFilePath = dirname(__FILE__) . "/client.sock";
            $serverSocketFilePath = dirname(__FILE__) . "/server.sock";
            $socket->create($socketFilePath);
            $socket->setNonBlock();
            $msg              = "Message";
            $socket->sendTo($msg, $serverSocketFilePath);
            $socket->setBlock();
            [$buf, $from] = $socket->receive();
            print_r(sprintf('Message "%s" was successfully sent', $buf));
            $socket->close();
            $socket->unlink($socketFilePath);
        } catch (Throwable $e) {
            print_r('An error has occurred. ' . $e->getMessage());
            return;
        }

        echo "Client exits\n";
    }
}
