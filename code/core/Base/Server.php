<?php

namespace Core\Base;

use \Core\Exceptions\InvalidArgumentException;
use Core\Services\SocketService;
use Core\Helpers\Console;

class Server extends SocketService
{
    private string $server_name = 'unix socket server';

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function socketListen(): void
    {
        $this->socket->socketCreate()
                     ->socketBind()
                     ->socketListen();

        Console::show('Start ' . $this->getServerName());
        $msg_sock = $this->socket->socketAccept();
        $this->socket->socketWrite('Connection ' . $this->getServerName(), $msg_sock);

        while (true) {
            $answer = $this->socket->socketRecv($msg_sock);
            if (($answer['buf'] === 'exit')) {
                $this->socket->socketClose($msg_sock);
                Console::show('Close connect ' . $this->getServerName());
                break;
            }
            $this->socket->socketWrite('Received ' . $answer['bytes'] . ' bytes', $msg_sock);
            Console::show('Message: ' . $answer['buf']);
        }

        $this->socket->socketClose();
    }

    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->server_name;
    }
}