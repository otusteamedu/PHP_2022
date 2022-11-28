<?php

namespace Koptev\Hw6;

use Exception;

class App
{
    public const MODE_SERVER = 'server';
    public const MODE_CLIENT = 'clients';

    /**
     * @param mixed $mode
     * @return void
     * @throws Exception
     */
    public function run(mixed $mode): void
    {
        $config = new Config();

        $config->load('socket');

        if ($mode === self::MODE_SERVER) {
            $server = new Server($config->get('socket.server'));

            $server->run();
        } elseif ($mode === self::MODE_CLIENT) {
            $client = new Client($config->get('socket.client'), $config->get('socket.server'));

            $client->run();
        } else {
            throw new Exception('Unknown parameter ' . $mode);
        }
    }
}
