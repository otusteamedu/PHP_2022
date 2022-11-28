<?php

namespace TemaGo\CommandChat;

class Server extends Socket
{
    public function __construct()
    {
        $this->socketName = Config::getConfig('SERVER_NAME');
    }
}
