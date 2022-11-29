<?php

namespace Waisee\SocketChat;

class ClientApp
{
    public function run()
    {
        while (true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;
            $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
            socket_connect($socket, Config::SOCKET);
            socket_write($socket, $message);
        }
    }

}