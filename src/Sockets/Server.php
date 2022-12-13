<?php

namespace Dkozlov\App\Sockets;

use Generator;

class Server extends Socket
{
    public function run(): Generator
    {
        while (true) {
            $received = $this->receive();

            $this->send('Received ' . $received['bytes'] . ' bytes', $received['address']);

            yield 'Received message: ' . $received['text'];
        }
    }
}