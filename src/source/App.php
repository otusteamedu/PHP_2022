<?php

namespace TemaGo\CommandChat;

class App {

    public function run(): void
    {
        $argv = $_SERVER['argv'];

        try {

            if (!isset($argv[1]) || !in_array($argv[1], ['server', 'client'])) {
                throw new \ErrorException('Некорректный аргумент запуска');
            }

            if ($argv[1] == 'server') {
                $server = new Server();
                $server->run();
            }

            if ($argv[1] == 'client') {
                $client = new Client();
                $client->run();
            }

        } catch (\ErrorException $e) {
            echo($e->getMessage()).PHP_EOL;
        }
    }
}
