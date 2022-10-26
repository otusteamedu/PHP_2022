<?php

namespace Nsavelev\Hw6\Services\SocketHelper\Interfaces;

use Nsavelev\Hw6\Services\SocketHelper\Exceptions\SocketErrorException;
use Socket;

interface SocketHelperInterface
{
    /**
     * @return Socket
     */
    public function createSocket(): Socket;

    /**
     * @param string $socketFilePath
     * @return Socket
     */
    public function createSocketFile(string $socketFilePath): Socket;

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

    /**
     * @return void
     * @throws SocketErrorException
     */
    public function checkSocketError(): void;
}