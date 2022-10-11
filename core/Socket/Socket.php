<?php

namespace Otus\Core\Socket;

class Socket
{
    private \Socket $socket;

    public function __construct(
        private readonly string $host,
        private readonly string $port,
    )
    {
    }

    public function create(
        int    $domain = AF_INET,
        int    $type = SOCK_STREAM,
        string $protocol = 'tcp',
    ): self
    {
        $socket = socket_create($domain, $type, getprotobyname($protocol));
        if ($socket instanceof \Socket) {
            $this->socket = $socket;
            return $this;
        }
        throw new SocketException('failed to create socket, ' . $this->getLastError());
    }

    public function connect(): self
    {
        if (socket_connect($this->socket, $this->host, $this->port) === false) {
            throw new SocketException('failed to connect socket, ' . $this->getLastError());
        }
        return $this;
    }

    public function bind(): self
    {
        if (socket_bind($this->socket, $this->host, $this->port) === false) {
            throw new SocketException('failed to bind socket, ' . $this->getLastError());
        }
        return $this;
    }

    public function listen(): self
    {
        if (socket_listen($this->socket) === false) {
            throw new SocketException('failed to listen socket, ' . $this->getLastError());
        }
        return $this;
    }

    public function accept(): self
    {
        if (socket_accept($this->socket) === false) {
            throw new SocketException('failed to accept socket, ' . $this->getLastError());
        }
        return $this;
    }

    public function recv(&$message, $flags = 0): int
    {
        $sendBytes = socket_recv($this->socket, $message, mb_strlen($message), $flags);
        if ($sendBytes === false) {
            throw new SocketException('failed to recv socket, ' . $this->getLastError());
        }
        return $sendBytes;
    }

    public function write(string $msg): self
    {
        $res = socket_write($this->socket, $msg, mb_strlen($msg));
        if ($res === false) {
            throw new SocketException('failed to write socket, ' . $this->getLastError());
        }
        return $this;
    }

    public function read(int $length = 1024): string
    {
        $msg = socket_read($this->socket, $length);
        if ( $msg === false) {
            throw new SocketException('failed to read socket, ' . $this->getLastError());
        }
        return  $msg;
    }

    private function getLastError(): string
    {
        return socket_strerror(socket_last_error($this->socket));
    }

    public function close(): self
    {
        socket_close($this->socket);
        return $this;
    }
}