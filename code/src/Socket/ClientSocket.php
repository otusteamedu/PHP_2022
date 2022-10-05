<?php

declare(strict_types=1);

namespace Nikolai\Php\Socket;

use Nikolai\Php\Exception\SocketException;
use Socket;

class ClientSocket extends AcceptedSocket
{
    public function __construct(Socket $socket, private string $socketFile)
    {
        parent::__construct($socket);
    }

    public function connect(): void
    {
        if (socket_connect($this->socket, $this->socketFile) === false) {
            throw new SocketException(
                "Не удалось выполнить socket_connect(): " . socket_strerror(socket_last_error($this->socket))
            );
        }
    }
}