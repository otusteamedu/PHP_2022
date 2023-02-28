<?php

namespace App;

class App
{

    public function run()
    {
        $factory = new SocketFactory(new Config());

        $socket = $factory->makeFromInput();

        $socket->connect();
        $socket->run();
    }
}
