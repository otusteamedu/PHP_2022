<?php

namespace TemaGo\CommandChat;

class Client extends Socket
{
    public function __construct()
    {
        $this->socketName = Config::getConfig('CLIENT_NAME');
    }

    public function run(): void
    {
        echo 'Клиент запущен...'.PHP_EOL;

        $this->openSocket();

        while (true) {
            echo("Введите сообщение. Для отправки, нажмите Enter:").PHP_EOL;
            $input = trim(fgets(STDIN));

            $message = new Message(
                (new Server())->getSocketName(),
                $input
            );

            $this->sendMessage($message);

            $response = $this->waitMessage();
            echo 'Ответ от сервера: '.$response->message.PHP_EOL;
        }
    }
}
