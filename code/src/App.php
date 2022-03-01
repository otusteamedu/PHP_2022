<?php

namespace KonstantinDmitrienko\App;

use KonstantinDmitrienko\App\Entity\Client;
use KonstantinDmitrienko\App\Entity\Server;

/**
 * Simple server-client chat via unix socket
 */
class App
{
    /**
     * @var Socket
     */
    protected Socket $socket;

    /**
     * @var Server
     */
    protected Server $server;

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var array|false 
     */
    public array $configs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->configs = parse_ini_file('config.ini', true);
        $this->socket = new Socket($this->configs['socket']);
        $this->server = new Server();
        $this->client = new Client();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if (!$type = $_SERVER['argv'][1]) {
            throw new \RuntimeException('Error: Required parameter client/server is not specified.');
        }

        $this->socket->create($type === 'server');

        switch ($type) {
            case 'server':
                $this->server->listen($this->socket);
                break;
            case 'client':
                $this->client->sendMessage($this->socket);
                break;
        }
    }
}
