<?php

namespace Unixsocket\App\Core;

use DI\Container;
use DI\ContainerBuilder;
use Unixsocket\App\Socket\Client;
use Unixsocket\App\Socket\Server;
use Unixsocket\App\Socket\SocketService;

class App
{
    private const APP_ROOT = '/var/www';
    private const CLIENT = 'client';
    private const SERVER = 'server';
    private const MAP = [
        self::CLIENT => Client::class,
        self::SERVER => Server::class,
    ];

    private Container $container;
    private array $config;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        $this->container = $builder->build();
        $this->config = parse_ini_file(self::APP_ROOT . '/config.ini');
    }

    public function run(array $arguments): void
    {
        $type = array_key_exists(1, $arguments) ? $arguments[1] : '';
        if (!array_key_exists($type, self::MAP)) {
            throw new \Exception('Неверное имя сервиса');
        }

        /** @var SocketService $service */
        $service = $this->container->make(self::MAP[$type], [
            'socketFile' => (string)$this->config['socket']
        ]);
        $service->connect();
        $service->run();
    }
}