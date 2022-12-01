<?php

namespace TemaGo\CommandChat;

class Socket
{

    public string $socketName = '';
    public $socket;

    public function __destruct()
    {
        if ($this->socket) {
            socket_close($this->socket);
        }
    }

    public function sendMessage(Message $message) : void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new \ErrorException('Невозможно установить режим для отправки данных');
        }

        $bytes = socket_sendto($this->socket, $message->message, $message->getLength(), 0, $message->from);

        if ($bytes == -1) {
            throw new \ErrorException('Ошибка получения данных из сокета');
        }
    }

    public function waitMessage() : Message
    {
        if (!socket_set_block($this->socket)) {
            throw new \ErrorException('Невозможно заблокировать сокет для получения данных');
        }

        $from = '';
        $message = '';

        $bytes = socket_recvfrom($this->socket, $message, 1024 * 10, 0, $from);

        if ($bytes == -1) {
            throw new \ErrorException('Ошибка получения данных из сокета');
        }

        return new Message($from, $message);
    }

    public function openSocket() : self
    {
        $socket = \socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket) {
            throw new \ErrorException('Невозможно инициализировать сокет');
        }

        if (!\socket_bind($socket, $this->getSocketName())) {
            throw new \ErrorException('Невозможно установить имя для сокета');
        }

        $this->socket = $socket;

        return $this;
    }

    public function getSocketName() : string
    {
        return $this->socketName.'.sock';
    }


}
