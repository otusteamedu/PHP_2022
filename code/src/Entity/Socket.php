<?php

namespace Otus\SocketApp\Entity;

use Exception;

class Socket
{
    private string $socketFile;

    /**
     * @var false|resource|\Socket
     */
    private $socket;

    /**
     * @var false|resource|\Socket
     */
    private $connection;

    public function __construct(string $file)
    {
        $this->socketFile = $file;
    }

    /**
     * @param $unlink
     * @return false|resource|\Socket
     */
    public function create(bool $unlink = false)
    {
        if ($unlink) {
            @unlink($this->socketFile);
        }

        return $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function connect(): bool
    {
        return socket_connect($this->socket, $this->socketFile);
    }

    public function bind(): void
    {
        if (socket_bind($this->socket, $this->socketFile) === false) {
            throw new Exception('Не удалось задать адресс сокету');
        }
    }

    public function accept(): void
    {
        $this->connection = socket_accept($this->socket);

        if (!$this->connection) {
            echo "Не удалось подключиться к сокету" . PHP_EOL;
            die();
        }
    }

    public function listen(): void
    {
        $result = socket_listen($this->socket);

        if (!$result) {
            throw new Exception('Не удалось подключиться к сокету');
        }
    }

    /**
     * @return false|string
     */
    public function read()
    {
        return socket_read($this->connection, 1024);
    }

    /**
     * @param string $message
     * @return void
     */
    public function send(string $message): void
    {
        socket_write($this->socket, $message);
    }

    public function closeSocket(bool $unlink = false): void
    {
        if ($unlink) {
            @unlink($this->socketFile);
        }

        socket_close($this->connection);
    }
}