<?php

declare(strict_types=1);

namespace Eliasjump\UnixChat\Socket;

use Socket;

class AppSocket
{
    private const FILE_NAME = '/socket/app.sock';
    private Socket|false $socket;
    private Socket|false $connection;

    /**
     * @throws SocketException
     */
    public function init(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new SocketException($this->socket, 'Не удалось создать сокет');
        }
    }

    /**
     * @throws SocketException
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, self::FILE_NAME)) {
            throw new SocketException($this->socket, 'Не удалось привязать сокет');
        }
    }

    /**
     * @throws SocketException
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket, 5)) {
            throw new SocketException($this->socket, 'Не удается прослушать сокет');
        }
    }

    /**
     * @throws SocketException
     */
    public function accept(): void
    {
        $this->connection = socket_accept($this->socket);
        if (!$this->connection) {
            throw new SocketException($this->socket, 'Не удалось выполнить принять соединение');
        }
    }

    /**
     * @throws SocketException
     */
    public function connect(): void
    {
        if (!socket_connect($this->socket, self::FILE_NAME)) {
            throw new SocketException($this->socket, 'Не удалось подключиться к сокету');
        }
    }

    public function send(string $message): void
    {
        socket_write($this->socket, $message);
    }

    /**
     * @throws SocketException
     */
    public function read(): string
    {
        if (!$socketMessage = socket_read($this->connection, 1024)) {
            throw new SocketException($this->socket, "Операция чтения не удалась");
        }
        return $socketMessage;
    }
}