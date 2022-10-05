<?php

declare(strict_types=1);

namespace Nikolai\Php\Socket;

use Nikolai\Php\Exception\SocketException;
use Socket;

class ServerSocket extends AcceptedSocket
{
    const MAX_SOCKET_CONNECTIONS = 5;

    public function __construct(Socket $socket, private string $socketFile)
    {
        parent::__construct($socket);
    }

    public function bind(): void
    {
        if (socket_bind($this->socket, $this->socketFile) === false) {
            throw new SocketException(
                "Не удалось выполнить socket_bind(): " . socket_strerror(socket_last_error($this->socket))
            );
        }
    }

    public function listen(): void
    {
        if (socket_listen($this->socket, self::MAX_SOCKET_CONNECTIONS) === false) {
            throw new SocketException(
                "Не удалось выполнить socket_listen(): " . socket_strerror(socket_last_error($this->socket))
            );
        }
    }

    public function accept(): AcceptedSocket
    {
        $clientSocket = socket_accept($this->socket);
        if ($clientSocket === false) {
            throw new SocketException(
                "Не удалось выполнить socket_accept(): " . socket_strerror(socket_last_error($this->socket))
            );
        }

        return new AcceptedSocket($clientSocket);
    }
}