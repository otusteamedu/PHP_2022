<?php

declare(strict_types=1);

namespace Nikolai\Php\Factory;

use Nikolai\Php\Exception\SocketException;
use Nikolai\Php\Socket\ClientSocket;
use Nikolai\Php\Socket\ServerSocket;

class SocketFactory
{
    public function __construct(private string $socketFile) {}

    private function createSocket(): \Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($socket === false) {
            throw new SocketException(
                "Не удалось выполнить socket_create(): " . socket_strerror(socket_last_error())
            );
        }

        return $socket;
    }

    public function createServerSocket(): ServerSocket
    {
        $socket = $this->createSocket();
        return new ServerSocket($socket, $this->socketFile);
    }

    public function createClientSocket(): ClientSocket
    {
        $socket = $this->createSocket();
        return new ClientSocket($socket, $this->socketFile);
    }
}