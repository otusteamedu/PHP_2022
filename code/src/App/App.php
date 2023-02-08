<?php

declare(strict_types=1);

namespace Kogarkov\Chat\App;

use Kogarkov\Chat\App\Server;
use Kogarkov\Chat\App\Client;
use Kogarkov\Chat\Config\Config;
use Kogarkov\Chat\Core\Service\Registry;

class App
{
    public $run_mode;

    public function __construct()
    {
        if (isset($_SERVER['argv']) && count($_SERVER['argv']) == 2) {
            $this->run_mode = $_SERVER['argv'][1];
        } else {
            throw new \Exception('Wrong param count');
        }

        Registry::instance()->set('config', new Config());
    }

    public function run(): void
    {
        switch ($this->run_mode) {
            case Constants::RUN_MODE_SERVER:
                $this->runServer();
                break;
            case Constants::RUN_MODE_CLIENT:
                $this->runClient();
                break;
            default:
                throw new \Exception('Wrong param run_mode. You can run app as "server" or "client"');
                break;
        }
    }

    private function runServer(): void
    {
        $server = new Server();
        $server->initialize();
        $server->run();
    }

    private function runClient(): void
    {
        $client = new Client();
        $client->initialize();
        $client->run();
    }
}
