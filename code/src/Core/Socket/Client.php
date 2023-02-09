<?php

declare(strict_types=1);

namespace Kogarkov\Chat\Core\Socket;

use Kogarkov\Chat\Core\Service\Registry;

class Client
{
    private $socket;
    private $host;

    public function __construct()
    {
        $config = Registry::instance()->get('config');
        $this->host = new Host($config->get('socket_path'));
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function connect(): void
    {
        $result = socket_connect($this->socket, $this->host->get());
        if (!$result) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function write(string $message): int
    {
        $result = socket_write($this->socket, $message, strlen($message));
        if (!$result) {
            new \Exception(socket_strerror(socket_last_error()));
        }
        return $result;
    }
}
