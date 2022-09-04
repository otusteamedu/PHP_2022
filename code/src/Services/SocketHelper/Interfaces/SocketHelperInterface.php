<?php

namespace Nsavelev\Hw6\Services\SocketHelper\Interfaces;

use Socket;

interface SocketHelperInterface
{
    /**
     * @param string $socketFilePath
     * @return Socket
     */
    public function create(string $socketFilePath): Socket;

    /**
     * @param string $socketFilePath
     * @return Socket
     */
    public function connect(string $socketFilePath): Socket;

    /**
     * @param Socket $socket
     * @param callable $messageHandler
     * @return void
     */
    public function listen(Socket $socket, callable $messageHandler): void;
}