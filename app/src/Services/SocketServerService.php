<?php

namespace Nka\OtusSocketChat\Services;

use Nka\OtusSocketChat\Socket;

/**
 * @property-read Socket $socket
 */
class SocketServerService
{
    public function __construct(
        private Socket $socket
    ){}

    public function listen()
    {
        $this->socket->create();

        if (!$this->socket->bind()) {
            throw new \RuntimeException('Couldn`t bind socket');
        }

        if (!$this->socket->listen()) {
            throw new \RuntimeException('Couldn`t listen socket');
        }

        while (true) {
            $buf = '';
            $client = $this->socket->accept();
            if ($bytes = $this->socket->receive($client, $buf)) {
                $resultMessage = 'Server received: ' . $bytes . ' bytes' . PHP_EOL;

                echo $resultMessage;
                echo 'Client message: ' . $buf . PHP_EOL;

                $this->socket->write($resultMessage, $client);
            }
        }
    }
}
