<?php

declare(strict_types=1);

namespace ATolmachev\MyApp\Sockets;

class SocketServer extends Socket
{
    public function run(): \Generator
    {
        while (true) {
            $received = $this->receive();
            $this->send("Получено {$received['bytes']} байт", $received['address']);

            yield "Полученное сообщение: {$received['text']}";
        }
    }
}
