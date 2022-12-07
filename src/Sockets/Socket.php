<?php

namespace Dkozlov\App\Sockets;

use Dkozlov\App\Sockets\Exceptions\BindFailedException;
use Dkozlov\App\Sockets\Exceptions\CreateFailedException;
use Dkozlov\App\Sockets\Exceptions\SendFailedException;

abstract class Socket
{

    protected string $file;

    /**
     * @var resource
     */
    protected $socket;

    /**
     * @throws CreateFailedException
     * @throws BindFailedException
     */
    public function __construct(string $file)
    {
        $this->file = $file;

        $this->prepareDir();
        $this->create();
        $this->bind();
    }

    public abstract function run(): void;

    /**
     * @throws CreateFailedException
     */
    protected function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new CreateFailedException('Failed to create socket');
        }
    }

    /**
     * @throws BindFailedException
     */
    protected function bind(): void
    {
        if (!socket_bind($this->socket, $this->file)) {
            throw new BindFailedException('Failed bind socket');
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

    /**
     * @throws SendFailedException
     */
    protected function send(string $message, string $address): void
    {
        if (!socket_sendto($this->socket, $message, strlen($message), 0, $address)) {
            throw new SendFailedException('Failed to send message');
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