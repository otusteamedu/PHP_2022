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
    abstract public function read();
    abstract public function write(string $text);
    abstract public function close();

    private function create(): void
    {
        if (!$this->socket) {
            $this->socket = \socket_create(AF_UNIX, SOCK_STREAM, 0);
        }
    }


    protected function show(string $message): void
    {
        echo $message . PHP_EOL;
    }

}
