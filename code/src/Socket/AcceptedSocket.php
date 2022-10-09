<?php

declare(strict_types=1);

namespace Nikolai\Php\Socket;

use Nikolai\Php\Exception\SocketException;
use Socket;

class AcceptedSocket
{
    const RECEIVE_LENGTH = 200;

    public function __construct(protected Socket $socket) {}

    public function send(string $message): int
    {
        $sendBytes = socket_send($this->socket, $message, strlen($message), 0);
        if ($sendBytes === false) {
            throw new SocketException(
                "Не удалось выполнить socket_send(): " . socket_strerror(socket_last_error($this->socket))
            );
        }

        return $sendBytes;
    }

    public function receive(string &$response): int
    {
        $receiveBytes = socket_recv($this->socket, $response, self::RECEIVE_LENGTH, 0);
        if ($receiveBytes === false) {
            throw new SocketException(
                "Не удалось выполнить socket_recv(): " . socket_strerror(socket_last_error($this->socket))
            );
        }

        return $receiveBytes;
    }

    public function close(): void
    {
        socket_close($this->socket);
    }
}