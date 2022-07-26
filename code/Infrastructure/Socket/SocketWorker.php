<?php

declare(strict_types=1);

namespace App\Infrastructure\Socket;

use JetBrains\PhpStorm\ArrayShape;
use RuntimeException;
use Socket;

class SocketWorker
{
    /** @var resource|Socket|false */
    private $socket;

    public function __construct(private readonly string $sockFile)
    {
        if (!extension_loaded('sockets')) {
            throw new RuntimeException('The sockets extension is not loaded.');
        }

        if (empty($sockFile)) {
            throw new RuntimeException('Empty socket filename provided.');
        }

        $this->create();
        $this->bind();
    }

    private function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new RuntimeException('Unable to create AF_UNIX socket');
        }
    }

    private function bind(): void
    {
        if (!socket_bind($this->socket, $this->sockFile)) {
            throw new RuntimeException("Unable to bind to $this->sockFile");
        }
    }

    public function __destruct()
    {
        $this->delete();
    }

    public function delete(): void
    {
        socket_close($this->socket);
        unlink($this->sockFile);
    }

    #[ArrayShape(['data' => "", 'from' => "", 'bytes' => "false|int"])]
    public function getData(): array
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket.');
        }

        $bytes_received = socket_recvfrom($this->socket, $data, 65536, 0, $from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket.');
        }

        return ['data' => $data, 'from' => $from, 'bytes' => $bytes_received];
    }

    public function sendData(string $data, string $address): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Unable to set nonblocking mode for socket.');
        }

        $len = strlen($data);
        $bytes_sent = socket_sendto($this->socket, $data, $len, 0, $address);

        if ($bytes_sent === -1) {
            throw new RuntimeException('An error occurred while sending to the socket.');
        }

        if ($bytes_sent !== $len) {
            throw new RuntimeException($bytes_sent.' bytes have been sent instead of the '.$len.' bytes expected.');
        }
    }
}