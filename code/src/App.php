<?php

namespace KonstantinDmitrienko\App;

use KonstantinDmitrienko\App\Entity\Client;
use KonstantinDmitrienko\App\Entity\Server;

class App
{
    protected $socket;
    protected Server $server;
    protected Client $client;

    public function __construct()
    {
        $this->server = new Server();
        $this->client = new Client();
    }

    public function run(): void
    {
        $type = $_SERVER['argv'][1] ?: null;

        $socket = new Socket();

        switch ($type) {
            case 'server':
                $socket->create(true);
                $this->server->listen($socket);
                break;
            case 'client':
                $socket->create();
                $this->client->sendMessage($socket);
                break;
        }
    }
}
