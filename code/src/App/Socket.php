<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\App;

use Nikcrazy37\Hw6\Exception\SocketException;

class Socket
{
    private string $file;
    private $sock;
    private $conn;

    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @param $sock
     * @return string
     */
    private function error($sock = null): string
    {
        return socket_strerror(socket_last_error($sock));
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function create()
    {
        if (($this->sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
            throw new SocketException("Не удалось выполнить socket_create(): причина: " . $this->error());
        }
    }

    /**
     * @return bool
     * @throws SocketException
     */
    public function connect(): bool
    {
        if (($this->conn = socket_connect($this->sock, $this->file)) === false) {
            throw new SocketException("Не удалось выполнить socket_connect(): причина: " . $this->error($this->sock));
        }

        return true;
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function bind()
    {
        if (socket_bind($this->sock, $this->file) === false) {
            throw new SocketException("Не удалось выполнить socket_bind(): причина: " . $this->error($this->sock));
        }
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function listen()
    {
        if (socket_listen($this->sock, 5) === false) {
            throw new SocketException("Не удалось выполнить socket_listen(): причина: " . $this->error($this->sock));
        }
    }

    /**
     * @return void
     * @throws SocketException
     */
    public function accept()
    {
        if (($this->conn = socket_accept($this->sock)) === false) {
            throw new SocketException("Не удалось выполнить socket_accept(): причина: " . $this->error($this->sock));
        }
    }

    /**
     * @return false|string
     * @throws SocketException
     */
    public function read()
    {
        if (false === ($buf = socket_read($this->conn, 2048, PHP_NORMAL_READ))) {
            throw new SocketException("Не удалось выполнить socket_read(): причина: " . $this->error($this->sock));
        }

        return $buf;
    }

    /**
     * @param $message
     * @return string
     * @throws SocketException
     */
    public function write($message): string
    {
        if (socket_write($this->sock, $message, strlen($message)) === false) {
            throw new SocketException("Не удалось выполнить socket_write(): причина: " . $this->error($this->sock));
        }

        return $message;
    }

    /**
     * @return void
     */
    public function close()
    {
        socket_close($this->conn);
    }
}