<?php

declare(strict_types=1);

namespace Sveta\Code;

final class UnixSocket
{
    private $socket;

    public function create(string $socketFilePath): void
    {
        if (!extension_loaded('sockets')) {
            throw new \Exception('The sockets extension is not loaded.');
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new \Exception('The sockets extension is not loaded.');
        }

        unlink($socketFilePath);
        if (!socket_bind($this->socket, $socketFilePath)) {
            throw new \Exception('The sockets extension is not loaded.');
        }
    }

    public function setBlock(): bool
    {
        if (!socket_set_block($this->socket)) {
            throw new \Exception('Unable to set blocking mode for socket');
        };

        return true;
    }

    public function setNonBlock(): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new \Exception('Unable to set nonblocking mode for socket');
        }
    }

    public function sendTo(string $buf, string $from): int
    {
        $length    = strlen($buf);
        $bytesSent = socket_sendto($this->socket, $buf, $length, 0, $from);

        if ($bytesSent == -1) {
            throw new \Exception('An error occured while sending to the socket');
        } else if ($bytesSent != $length) {
            throw new \Exception($bytesSent . ' bytes have been sent instead of the ' . $length . ' bytes expected');
        }

        return $bytesSent;
    }

    public function receive(): array
    {
        $buf            = '';
        $from           = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new \Exception('An error occurred while receiving from the socket');
        }

        return [$buf, $from, $bytes_received];
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function unlink(string $path): void
    {
        unlink($path);
    }
}
