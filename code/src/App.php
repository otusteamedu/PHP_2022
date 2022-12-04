<?php

namespace Waisee\SocketChat;

abstract class App
{
    public function createSocket(): bool|\Socket
    {
        return socket_create(AF_UNIX, SOCK_STREAM, 0);
    }
}