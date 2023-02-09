<?php

declare(strict_types=1);

namespace Kogarkov\Chat\Core\Socket;

use Kogarkov\Chat\Core\Service\Registry;

class Server
{
    private $socket;
    private $client;
    private $host;

    public function __construct()
    {
        $config = Registry::instance()->get('config');
        $this->host = new Host($config->get('socket_path'));
        $this->host->initialize();
    }

    public function create(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function bind(): void
    {
        $result = socket_bind($this->socket, $this->host->get());
        if (!$result) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function listen(): void
    {
        $result = socket_listen($this->socket);
        if (!$result) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function accept(): void
    {
        $this->client = socket_accept($this->socket);
        if (!$this->client) {
            new \Exception(socket_strerror(socket_last_error()));
        }
    }

    public function read(): string
    {
        if (!$this->client) {
            new \Exception(socket_strerror(socket_last_error()));
        }
        $message = socket_read($this->client, 1024);
        if (!$message) {
            new \Exception(socket_strerror(socket_last_error()));
        }
        return $message;
    }
}
