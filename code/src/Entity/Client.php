<?php

namespace KonstantinDmitrienko\App\Entity;

/**
 * Class for sending outgoing messages
 */
class Client
{
    /**
     * @param $socket
     *
     * @return void
     */
    public function sendMessage($socket): void
    {
        $socket->connect();

        while (true) {
            $message = readline('Enter your message: ');
            $socket->write($message);
            echo "Server response: {$socket->read()}\n\n";
        }
    }
}
