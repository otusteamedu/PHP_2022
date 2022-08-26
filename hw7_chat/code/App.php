<?php

/**
 * Client app
 */

declare(strict_types=1);

namespace App;

use App\Service\Logger\ConsoleLogger;
use App\Chat\{Client, Server};
use App\Service\ConfigReader;
use RuntimeException;

class App
{
    public static string $config_file;
    protected array $options = [];
    public static string $BASE_PATH;
    public static string $APP_PATH;
    protected string $app_type;

    /**
     * Client app constructor
     * @param array $argv
     * @param string $BASE_PATH
     */
    public function __construct(array $argv, string $BASE_PATH)
    {
        if (!isset($argv[1])) {
            throw new RuntimeException('Empty script parameters.');
        }

        if (!in_array($argv[1], ['server', 'client'])) {
            throw new RuntimeException('Wrong script parameters.');
        }

        $this->app_type = $argv[1];

        self::$BASE_PATH = $BASE_PATH;
        self::$APP_PATH = realpath(self::$BASE_PATH . '/code');
        self::$config_file = self::$APP_PATH . '/config.ini';

        $config = new ConfigReader(self::$config_file);
        $this->options = $config->getOptions();
    }

    /**
     * Run client code
     * @return void
     */
    public function run(): void
    {
        $serv_socket_path = self::$BASE_PATH . $this->options['chat']['server_socket'] ?? null;
        $client_socket_path = self::$BASE_PATH . $this->options['chat']['client_socket'] ?? null;

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