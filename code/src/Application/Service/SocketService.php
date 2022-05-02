<?php
declare(strict_types=1);


namespace Otus\SocketApp\Application\Service;


use RuntimeException;
use Socket;

final class SocketService
{
    private string $socketFile;

    /**
     * @var false|resource|Socket
     */
    private $socket;

    /**
     * @var false|resource|Socket
     */
    private $connection;

    public function __construct(string $file)
    {
        $this->socketFile = $file;
    }

    public function create(bool $unlink = false)
    {
        if ($unlink) {
            unlink($this->socketFile);
        }

        return $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function closeSocket(bool $unlink = false): void
    {
        if ($unlink) {
            unlink($this->socketFile);
        }

        socket_close($this->connection);
    }

    public function connect(): bool
    {
        return socket_connect($this->socket, $this->socketFile);
    }

    /**
     * @throws RuntimeException
     */
    public function bind(): void
    {
        if (socket_bind($this->socket, $this->socketFile) === false) {
            if (is_file($this->socketFile)) {
                unlink($this->socketFile);
            }

            throw new RuntimeException('Не удалось задать адресс сокету');
        }
    }

    /**
     * @throws RuntimeException
     */
    public function accept(): void
    {
        $this->connection = socket_accept($this->socket);

        if (!$this->connection) {
            throw new RuntimeException('Не удалось подключиться к сокету');
        }
    }

    /**
     * @throws RuntimeException
     */
    public function listen(): void
    {
        $result = socket_listen($this->socket);

        if (!$result) {
            throw new RuntimeException('Не удалось подключиться к сокету');
        }
    }

    public function read(): mixed
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
}