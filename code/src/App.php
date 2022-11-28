<?php

declare(strict_types=1);

namespace Study\Chat;

use Study\Chat\Service\Client;
use Study\Chat\Service\Server;
use Exception;


class App
{
    private string $socket_type;

    public function __construct()
    {
        $this->socket_type = $_SERVER['argv'][1] ?? '';
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
       /* if(extension_loaded('sockets')){
            echo "Расширение sockets не установлено.";
            return;
        }
       */
        if($this->socket_type == 'server' ) {
            (new Server())->run();
        }
        elseif($this->socket_type == 'client' ) {
            (new Client())->run();
        }
        elseif($this->socket_type == 'stop' ) {
            (new Client())->close();
        }
        else
        {
            throw new Exception( 'Неизвестный флаг. Укажите server или client.' );
        }

    }
}