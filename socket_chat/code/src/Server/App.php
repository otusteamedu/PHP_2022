<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\Server;

use Mapaxa\SocketChatApp\Config\SocketConfig;
use Mapaxa\SocketChatApp\Socket\Socket;

class App
{

    private $socket;
    public function __construct()
    {
        $this->socket = new Socket(SocketConfig::SocketFileName);
    }

    public function execute():void
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