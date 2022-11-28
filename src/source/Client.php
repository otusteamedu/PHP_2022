<?php

namespace TemaGo\CommandChat;

class Client extends Socket
{
    public function __construct()
    {
        $this->socketName = Config::getConfig('CLIENT_NAME');
    }
}
