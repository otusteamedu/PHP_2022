<?php

namespace Koptev\Hw6;

use Exception;

class App
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(string $mode)
    {
        $config = new Config();

        $config->load('socket');

        if ($mode === 'server') {
            $server = new Server($config->get('socket.server'));

            $server->run();
        } else {
            $client = new Client($config->get('socket.client'), $config->get('socket.server'));

            $client->run();
        }
    }
}
