<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\App;

use Mapaxa\SocketChatApp\Config\SocketConfig;
use Mapaxa\SocketChatApp\Socket\Socket;

class Server implements AppInterface
{

    private $socket;
    public function __construct()
    {
        $this->socket = new Socket(SocketConfig::SOCKET_FILE_NAME);
    }

    public function execute(): void
    {
        $this->socket->init();

        $this->socket->bind();
        $this->socket->listen();

        while (true) {
            $this->socket->accept();
            echo $this->socket->read();
        }
        $this->socket->closeSocket();
    }
}