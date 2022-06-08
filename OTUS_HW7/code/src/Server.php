<?php

declare(strict_types=1);

namespace Shilyaev\Chat;

class Server
{
    protected $socket;
    protected string $socket_name;
    protected int $max_message_length;

    public function __construct()
    {
        if (!extension_loaded('sockets')) {
            throw new \Exception('Расширение sockets не загружено');
        }
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        }
        catch (\Exception $e)
        {
            throw new \Exception('Ошибка создания сокета для чата');
        }


    }

    public function init(array $settings): void
    {
        $this->socket_name=isset($settings['socket_name']) ? $settings['socket_name'] : '/tmp/chat.sock';
        $this->max_message_length=isset($settings['max_message_length']) ? (int)$settings['max_message_length'] : 1024;
    }

    public function run(): void
    {
        if (!socket_bind($this->socket, $this->socket_name))
            throw new \Exception("Не могу подсоединиться к $this->socket_name");
        if (!socket_listen($this->socket,1))
            throw new \Exception("Ошибка установления прослушивания сокета: " . socket_strerror(socket_last_error($this->sock)));


        if (($msgsock = socket_accept($this->socket)) === false) {
            throw new \Exception("socket_accept() failed: reason: " . socket_strerror(socket_last_error($msgsock)));
        }

        $isNotExit = true;
        do {
            if (false === ($buf = socket_read($msgsock, $this->max_message_length, PHP_NORMAL_READ))) {
                throw new \Exception("socket_read() failed: " . socket_strerror(socket_last_error($msgsock)));
            }
            if ($buf != "quit\r") {
                $talkback = "Received " . strlen($buf) . " bytes\r";
                socket_write($msgsock, $talkback, strlen($talkback));
            }
            else
                $isNotExit = false;

        } while ($isNotExit);

        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }
}