<?php

declare(strict_types = 1);

namespace Veraadzhieva\Hw6;

use Exception;
use Veraadzhieva\Hw6\Service\Config;
use Veraadzhieva\Hw6\Chat\Server;
use Veraadzhieva\Hw6\Chat\Client;

class App
{
    protected $configs = [];
    protected $app_type;

    /*
     * App.
     *
     * @param array $argv
     *
     * @return null|Exception
     */
    public function __construct(array $argv)
    {
        $this->app_type = $argv[1];

        try {
            $config = new Config('/config.ini');
            $this->configs = $config->getConfigs();
        } catch (Exception $e) {
            return $e;
        }
        return null;
    }

    /*
     * Запуск приложения.
     *
     * @return null|Exception
     */
    public function run()
    {
        $server_config = $this->options['server_socket'] ?? null;
        $client_config = $this->options['client_socket'] ?? null;

        if ($this->app_type === 'server') {
            try {
                $server = new Server($server_config);
                $server->startServer();
            } catch (Exception $e) {
                return $e;
            }
        } else {
            try {
                $client = new Client($client_config, $server_config);
                $client->startClient();
            } catch (Exception $e) {
                return $e;
            }
        }
        return null;
    }
}