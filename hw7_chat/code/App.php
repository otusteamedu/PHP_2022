<?php

declare(strict_types=1);

namespace App;

use App\Service\Logger\ConsoleLogger;
use App\Chat\{Client, Server};
use App\Service\ConfigReader;
use RuntimeException;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    protected string $app_type;

    public function __construct(array $argv)
    {
        if (!isset($argv[1])) {
            throw new RuntimeException('Empty script parameters.');
        }

        if (!in_array($argv[1], ['server', 'client'])) {
            throw new RuntimeException('Wrong script parameters.');
        }

        $this->app_type = $argv[1];

        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    public function run(): void
    {
        $serv_socket_path = $this->options['chat']['server_socket'] ?? null;
        $client_socket_path = $this->options['chat']['client_socket'] ?? null;

        $logger = new ConsoleLogger();

        if ($this->app_type === 'server') {
            $server = new Server($serv_socket_path, $logger);
            $server->run();
        } else {
            $client = new Client($client_socket_path, $serv_socket_path, $logger);
            $client->run();
        }
    }
}