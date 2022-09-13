<?php

declare(strict_types=1);

namespace Mapaxa\SocketChatApp\Socket;

use Exception;
use Mapaxa\SocketChatApp\Exception\SocketException;

class Socket
{
    private $file;
    private $socket;
    private $connection;

    public function __construct(string $file)
    {
        $this->file = $file;
    }


    public function init(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function bind(): void
    {
        if (socket_bind($this->socket, $this->file) === false) {
            throw new SocketException("Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    public function listen(): void
    {
        if (socket_listen($this->socket, 5) === false) {
            throw new SocketException("Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
    }

    public function accept(): void
    {
        if (socket_accept($this->socket) === false) {
            throw new SocketException("Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($this->socket)) . "\n");
        }
        $this->connection = socket_accept($this->socket);
    }

    public function connect(): bool
    {
        return socket_connect($this->socket, $this->file);
    }

    public function send(string $message): void
    {
        socket_write($this->socket, $message);
    }

    public function show(string $message): void
    {
        echo $message;
    }

    public function read()
    {
        $socketMessage = socket_read($this->connection, 1024);
        if ($socketMessage === false ) {
            throw new SocketException("Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($this->socket)) . "\n");;
        }
        return $socketMessage;
    }


    public function closeSocket(): void
    {
        socket_close($this->connection);
    }
}