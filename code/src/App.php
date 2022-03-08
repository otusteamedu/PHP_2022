<?php

namespace KonstantinDmitrienko\App;

use KonstantinDmitrienko\App\CommandControllers\Client;
use KonstantinDmitrienko\App\CommandControllers\Server;
use KonstantinDmitrienko\App\Socket\SocketClient;
use KonstantinDmitrienko\App\Socket\SocketServer;

/**
 * Simple server-client chat via unix socket
 */
class App
{
    /**
     * @var SocketServer|SocketClient
     */
    protected SocketServer|SocketClient $socket;

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
    public array|bool $configs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->configs = parse_ini_file('config.ini', true);
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

        switch ($type) {
            case 'server':
                $this->socket = new SocketServer($this->configs['socket']);
                $this->socket->create();
                $this->server->listen($this->socket);
                break;
            case 'client':
                $this->socket = new SocketClient($this->configs['socket']);
                $this->socket->create();
                $this->client->sendMessage($this->socket);
                break;
        }
    }
}
