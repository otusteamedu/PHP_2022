<?php

declare(strict_types=1);

namespace Kogarkov\Chat\App;

use Kogarkov\Chat\Core\Socket\Server as ServerSocket;

class Server
{
    private $socket;

    public function __construct()
    {
        $this->socket = new ServerSocket();
    }

    public function initialize(): void
    {
        $this->socket->create();
        $this->socket->bind();
        $this->socket->listen();
        $this->socket->accept();
    }

    public function run(): void
    {
        while (true) {
            $message = $this->socket->read();
            if ($message) {
                echo "Message from Client: $message";
            }
        }
    }
}
