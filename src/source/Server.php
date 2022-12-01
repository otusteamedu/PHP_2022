<?php

namespace TemaGo\CommandChat;

class Server extends Socket
{
    public function __construct()
    {
        $this->socketName = Config::getConfig('SERVER_NAME');
    }

    public function run(): void
    {
        echo 'Сервер запущен...'.PHP_EOL;

        $this->openSocket();

        while(true) {
            $message = $this->waitMessage();

            echo "Получено сообщение от клиента: ".$message->message.PHP_EOL;

            $response = new Message(
                $message->from,
                $message->getLength().' bytes'
            );

            $this->sendMessage($response);
        }
    }
}
