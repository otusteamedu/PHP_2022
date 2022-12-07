<?php

namespace Dkozlov\App\Sockets;

class Server extends Socket
{
    public function run(): void
    {
        while (true) {
            $received = $this->receive();

            echo 'Received message: ' . $received['text'] . PHP_EOL;

            $this->send('Received ' . $received['bytes'] . ' bytes', $received['address']);
        }
    }
}