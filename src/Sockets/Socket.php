<?php

namespace Otus\HW6\Sockets;

use Generator;
use Exception;

abstract class Socket
{
    protected string $file;
    protected $socket;

    public function __construct(string $file)
    {
        $this->file = $file;
        try {
            $this->prepareDir();
            $this->create();
            $this->bind();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    abstract public function run(): Generator;

    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new Exception('Не удалось создать сокет');
        }
    }

    protected function bind(): void
    {
        if (!socket_bind($this->socket, $this->file)) {
            throw new Exception('Не удалось привязать сокет');
        }
    }

    protected function receive(): array
    {
        $bytes = socket_recvfrom($this->socket, $message, 65536, 0, $address);

        return [
            'bytes' => $bytes,
            'text' => $message,
            'address' => $address
        ];
    }

    protected function send(string $message, string $address): void
    {
        if (!socket_sendto($this->socket, $message, strlen($message), 0, $address)) {
            throw new Exception('Не удалось отправить сообщение');
        }
    }

    protected function prepareDir(): void
    {
        $dirname = dirname($this->file);

        if (!file_exists($dirname)) {
            mkdir($dirname);
        }

        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }
}
