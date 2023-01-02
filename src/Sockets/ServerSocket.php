<?php

namespace Otus\HW6\Sockets;

use Generator;

class ServerSocket extends Socket
{
    public function run(): Generator
    {
        while (true) {
            $received = $this->receive();
            $this->send('Получено ' . $received['bytes'] . ' байт', $received['address']);

            yield 'Полученное сообщение: ' . $received['text'];
        }
    }
}
