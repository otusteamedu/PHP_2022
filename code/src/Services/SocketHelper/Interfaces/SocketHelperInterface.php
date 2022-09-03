<?php

namespace Nsavelev\Hw6\Services\SocketHelper\Interfaces;

use Socket;

interface SocketHelperInterface
{
    /**
     * @param Socket $socket
     * @param callable $messageHandler
     * @return void
     */
    public function listen(Socket $socket, callable $messageHandler): void;
}