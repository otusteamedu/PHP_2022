<?php

declare(strict_types=1);

namespace App;

use App\Chat\{Client, Server};
use App\Service\ConfigReader;
use RuntimeException;

class App
{
    public static string $config_file = APP_PATH.'/config.ini';
    protected array $options = [];

    public function __construct()
    {
        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    public function run(): void
    {
        global $argv;

        if (!isset($argv[1])) {
            throw new RuntimeException('Empty script parameters.');
        }

        $serv_socket_path = $this->options['chat']['server_socket'] ?? null;
        $client_socket_path = $this->options['chat']['client_socket'] ?? null;

        if ($argv[1] === 'server') {

            $server = new Server($serv_socket_path);
            $server->run();

        } elseif ($argv[1] === 'client') {

            $client = new Client($client_socket_path, $serv_socket_path);
            $client->run();

        } else {
            throw new RuntimeException('Wrong script parameters.');
        }
    }
}