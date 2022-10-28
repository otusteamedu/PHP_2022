<?php

declare(strict_types=1);

namespace App;

use App\Logger\MyLogger;
use App\Core\Client;
use App\Core\Server;
use App\Config\Configurator;
use RuntimeException;

class App
{
    public static string $config_file = APP_PATH.'/Config/config.ini';
    protected array $options = [];
    protected string $app_type;

    public function __construct(array $argv)
    {
        if (!isset($argv[1])) {
            throw new RuntimeException('Не указан аргумент клиент или сервер.');
        } else {
                if (!in_array($argv[1], ['server', 'client'])) {
                    throw new RuntimeException('Неправильные параметры (надо либо клиент, либо сервер)');
                }
        }

        $this->app_type = $argv[1];

        $config = new Configurator(self::$config_file);
        $this->options = $config->getOptions();
    }

    public function run(): void
    {
        $serv_socket_path = $this->options['core']['server_socket'] ?? null;
        $client_socket_path = $this->options['core']['client_socket'] ?? null;

        $logger = new MyLogger();

        if ($this->app_type === 'server') {
            $server = new Server($serv_socket_path, $logger);
            $server->run();
        } else {
            $client = new Client($client_socket_path, $serv_socket_path, $logger);
            $client->run();
        }
    }
}
