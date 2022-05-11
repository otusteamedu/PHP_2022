<?php

namespace App;

abstract class Socket
{
    protected const CLOSE_COMMAND = 'close';

    protected $socket;
    protected string $address;

    public function __construct(string $address)
    {
        $this->address = $address;
        $this->create();
    }

    abstract public function connect();
    abstract public function run();
    abstract public function write(string $text);
    abstract public function close();

    public function read($socket)
    {
        return socket_read($socket, 1024);
    }


    protected function show(string $message): void
    {
        echo $message . PHP_EOL;
    }


    protected function bind(): void
    {
        \socket_bind($this->socket, $this->address);
    }

    protected function listen(): void
    {
        \socket_listen($this->socket);
    }


    private function create(): void
    {
        if (!$this->socket) {
            $this->socket = \socket_create(AF_UNIX, SOCK_STREAM, 0);
        }
    }
}
