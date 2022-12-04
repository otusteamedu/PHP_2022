<?php

namespace Waisee\SocketChat;

class ServerApp extends App
{
    public function run()
    {
        $socket = $this->createSocket();
        socket_bind($socket, Config::SOCKET);
        socket_listen($socket, 5);

        while (true) {
            if (false === ($conn = socket_accept($socket))) {
                continue;
            }
            if (false !== ($data = socket_read($conn, 1024))) {
                echo $data;
            }
        }
    }
}

