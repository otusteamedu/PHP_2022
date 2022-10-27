<?php

declare(strict_types=1);


namespace ATolmachev\MyApp;


use ATolmachev\MyApp\Exceptions\AppException;
use ATolmachev\MyApp\Sockets\Socket;
use ATolmachev\MyApp\Sockets\SocketClient;
use ATolmachev\MyApp\Sockets\SocketServer;

class App
{
    private const CONFIG_PATH = '../config/config.ini';

    private const MODE_SERVER = 'server';
    private const MODE_CLIENT = 'client';

    private string $mode;

    private Configuration $config;

    public function __construct(string $mode)
    {
        $this->mode = $mode;
        $this->config = new Configuration(self::CONFIG_PATH);
    }

    /**
     * @throws AppException
     */
    public function run(): void
    {
        $socket = $this->createSocket();
        foreach ($socket->run() as $message) {
            echo $message . PHP_EOL;
        }
    }

    /**
     * @throws AppException
     */
    private function createSocket(): Socket
    {
        return match ($this->mode) {
            self::MODE_SERVER => new SocketServer($this->config->get('server')),
            self::MODE_CLIENT => new SocketClient($this->config->get('client'), $this->config->get('server')),
            default => throw new AppException(
                "Режима {$this->mode} не существует. Используйте один из следующих вариантов: "
                . self::MODE_SERVER . ', ' . self::MODE_CLIENT
            )
        };
    }
}