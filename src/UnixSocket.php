<?php

namespace AKhakhanova\Hw4;

use Monolog\Logger;
use Socket;

class UnixSocket
{
    private ?Socket $socket = null;
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('socket');
    }

    public function create(string $socketFilePath): bool
    {
        if (!extension_loaded('sockets')) {
            $this->logger->error('The sockets extension is not loaded.');

            return false;
        }

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            $this->logger->error('The sockets extension is not loaded.');

            return false;
        }

        unlink($socketFilePath);
        if (!socket_bind($this->socket, $socketFilePath)) {
            $this->logger->error('The sockets extension is not loaded.');

            return false;
        }

        return true;
    }

    public function setBlock(): bool
    {
        if (!socket_set_block($this->socket)) {
            $this->logger->error('Unable to set blocking mode for socket');
        };

        return true;
    }

    public function setNonBlock(): bool
    {
        if (!socket_set_nonblock($this->socket)) {
            die('Unable to set nonblocking mode for socket');
        }
    }

    public function sendTo(string $buf, string $from): int
    {
        $length    = strlen($buf);
        $bytesSent = socket_sendto($this->socket, $buf, $length, 0, $from);

        if ($bytesSent == -1) {
            die('An error occured while sending to the socket');
        } else if ($bytesSent != $length) {
            die($bytesSent . ' bytes have been sent instead of the ' . $length . ' bytes expected');
        }

        return $bytesSent;
    }

    public function getBytesReceivedInfo(): array
    {
        $buf            = '';
        $from           = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            die('An error occurred while receiving from the socket');
        }

        return [$buf, $from, $bytes_received];
    }

    public function receiveFrom(): void
    {
        $buf            = '';
        $from           = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            die('An error occured while receiving from the socket');
        }
        echo "Received $buf from $from\n";
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
