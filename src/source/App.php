<?php

namespace TemaGo\CommandChat;

class App {

    private function runServer(): void
    {
        echo 'Сервер запущен...'.PHP_EOL;

        $server = new Server();
        $server->openSocket();

        while(true) {
            $message = $server->waitMessage();

            echo "Получено сообщение от клиента: ".$message->message.PHP_EOL;

            $response = new Message(
                $message->from,
                $message->getLength().' bytes'
            );

            $server->sendMessage($response);
        }
    }

    private function runClient(): void
    {
        echo 'Клиент запущен...'.PHP_EOL;

        $client = new Client();
        $client->openSocket();

        while (true) {
            echo("Введите сообщение. Для отправки, нажмите Enter:").PHP_EOL;
            $input = trim(fgets(STDIN));

            $message = new Message(
                (new Server())->getSocketName(),
                $input
            );

            $client->sendMessage($message);

            $response = $client->waitMessage();
            echo 'Ответ от сервера: '.$response->message.PHP_EOL;
        }
    }

    public function run(): void
    {
        $argv = $_SERVER['argv'];

        try {
            if (!isset($argv[1]) || !in_array($argv[1], ['server', 'client'])) {
                throw new \ErrorException('Некорректный аргумент запуска');
            }

            if ($argv[1] == 'server') {
                $this->runServer();
            }

            if ($argv[1] == 'client') {
                $this->runClient();
            }
        } catch (\ErrorException $e) {
            echo($e->getMessage()).PHP_EOL;
        }
    }
}
