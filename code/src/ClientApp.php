<?php

namespace Waisee\SocketChat;

class ClientApp extends App
{
    public function run()
    {
        while (true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;
            $socket = $socket = $this->createSocket();
            socket_connect($socket, Config::SOCKET);
            socket_write($socket, $message);
        }
    }

}