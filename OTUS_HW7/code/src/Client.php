<?php

declare(strict_types=1);

namespace Shilyaev\Chat;

class Client
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

    protected function createSocket() : void
    {
        $result = socket_connect($this->socket, $this->socket_name, 0);
        if ($result === false) {
            throw new \Exception("Не могу соединиться с сокетом: ($result) " . socket_strerror(socket_last_error($this->socket)));
        }
    }

    protected function closeSocket() : void
    {
        echo "Closing socket...";
        $line = "quit\r";
        socket_write($this->socket, $line, strlen($line));
        socket_close($this->socket);
        echo "OK.\n\n";
    }

    protected function startChat() : void
    {
        $isNotExit = true;
        do {
            $line = readline("Message: ")."\r";
            socket_write($this->socket, $line, strlen($line));
            if ($line != "quit\r") {
                if ($out = socket_read($this->socket, $this->max_message_length, PHP_NORMAL_READ)) {
                    echo $out . "\n";
                }
            }
            else
                $isNotExit = false;

        } while ($isNotExit);
    }

    public function run() : void
    {
       $this->createSocket();
       $this->startChat();
       $this->closeSocket();
    }
}