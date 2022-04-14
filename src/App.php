<?php

namespace App;

class App
{

    public function run()
    {
        $factory = new SocketFactory(new Config());

        $socketType = $_SERVER['argv'][1] ?? '';
        $socket = $factory->make($socketType);

        $socket->connect();
        $socket->run();
    }
}
