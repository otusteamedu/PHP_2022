<?php

namespace Otus\HW6;

use Otus\HW6\Sockets\ClientSocket;
use Otus\HW6\Sockets\ServerSocket;
use Otus\HW6\Sockets\Socket;

class App
{
    private const CONFIG_PATH = __DIR__ . '/../config/config.ini';
    private const SERVER = 'server';

    private const CLIENT = 'client';

    private Config $config;

    private string $mode;

    public function __construct($mode)
    {
        $this->config = new Config(self::CONFIG_PATH);
        $this->mode = $mode;
    }

    public function run(): void
    {
        try {
            $socket = $this->buildSocket();
            foreach ($socket->run() as $message) {
                echo $message . PHP_EOL;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function buildSocket(): Socket
    {
        return match ($this->mode) {
            self::CLIENT => new ClientSocket($this->config->get('client'), $this->config->get('server')),
            self::SERVER => new ServerSocket($this->config->get('server')),
            default => throw new \Exception('Неопределенный режим приложения: ' . $this->mode),
        };
    }
}