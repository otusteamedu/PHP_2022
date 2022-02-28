<?php

namespace KonstantinDmitrienko\App;

use Exception;

class Socket
{
    public $socket;

    protected $socketFile = '/sock/sock.sock';

    public function create($removeSocketFile = false)
    {
        if ($removeSocketFile && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0) ) {
            echo "Socket created \n";
            return $this->socket;
        }

        throw new \RuntimeException('Socket is not created.');
    }

    public function bind()
    {
        if (socket_bind($this->socket, $this->socketFile)) {
            echo "Socket bind OK \n";
        } else {
            throw new \RuntimeException();
        }
    }

    public function listen()
    {
        if (socket_listen($this->socket, 5)) {
            echo "Socket listen OK \n";
        } else {
            throw new \RuntimeException();
        }
    }

    public function connect()
    {
        if (socket_connect($this->socket, $this->socketFile)) {
            echo "Socket connect OK \n";
            return;
        }

        throw new \RuntimeException();
    }

    public function accept()
    {
        if ($socket = socket_accept($this->socket)) {
            echo "Socket accept OK \n";
            return $socket;
        }

        throw new \RuntimeException();
    }

    public function write($message, $socket = null)
    {
        $socket = $socket ?: $this->socket;
        if (socket_write($socket, $message, strlen($message))) {
            echo "Message written OK \n";
            return;
        }

        throw new \RuntimeException();
    }

    public function read($socket = null)
    {
        $socket = $socket ?: $this->socket;
        return socket_read($socket, 2048);
    }

    public function close($socket = null)
    {
        $socket = $socket ?: $this->socket;
        socket_close($this->socket);
    }

    public function setBlock()
    {
        socket_set_block($this->socket);
    }

    public function unBlock()
    {
        socket_set_nonblock($this->socket);
    }
}
