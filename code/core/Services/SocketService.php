<?php

namespace Core\Services;

use Core\Base\Socket;

class SocketService
{
    /**
     * @var Socket $socket
     */
    protected Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }
}