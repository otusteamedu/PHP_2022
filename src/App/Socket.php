<?php
declare(strict_types=1);

namespace Qween\Php2022\App;

use Exception;

class Socket
{
    private string $file;

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
        $this->file = $file;
    }

    /**
     * @param bool $unlink
     *
     * @return bool
     */
    public function create(bool $unlink = false)
    {
        if ($unlink) {
            @unlink($this->file);
        }

        return $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    public function connect(): bool
    {
        return socket_connect($this->socket, $this->file);
    }

    /**
     * @throws Exception
     */
    public function bind(): void
    {
        if (!socket_bind($this->socket, $this->file)) {
            $error = $this->error($this->socket);
            throw new Exception($error);
        }
    }

    public function accept(): void
    {
        $this->connection = socket_accept($this->socket);

        if (!$this->connection) {
            echo $this->error($this->socket) . PHP_EOL;
            exit();
        }
    }

    /**
     * @throws Exception
     */
    public function listen(): void
    {
        $result = socket_listen($this->socket);

        if (!$result) {
            $error = $this->error($this->socket);
            throw new Exception($error);
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
            @unlink($this->file);
        }

        socket_close($this->connection);
    }

    /**
     * @param $socket
     *
     * @return string
     */
    private function error($socket = null): string
    {
        return socket_strerror(socket_last_error($socket));
    }
}
