<?php

namespace App;

use Core\Base\Client;
use Core\Base\Server;
use Core\Exceptions\InvalidArgumentException;

class Application
{
    /**
     * @var Client $client
     * @var Server $server
     * @var Application $app
     */
    private Client $client;
    private Server $server;
    public static Application $app;

    public function __construct()
    {
        $this->setInstance($this);
        $this->server = new Server();
        $this->client = new Client();
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function run() :void
    {
        $this->preInit();

        if ($this->getType() === 'server') {
            $this->server->socketListen();
        }

        if ($this->getType() === 'client') {
            $this->client->sendMessage();
        }
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function preInit() :void
    {
        if (!in_array($this->getType(), ['server', 'client'], true)) {
            throw new InvalidArgumentException('Warning: The argument could be only "server" or "client"');
        }
    }

    /**
     * @return string
     */
    public function getType() :string
    {
        return $_SERVER['argv'][1] ?? '';
    }

    /**
     * @param Application $instance
     * @return void
     */
    private function setInstance(Application $instance) :void
    {
        self::$app = $instance;
    }

    /**
     * @return Server
     * @throws InvalidArgumentException
     */
    public function getServer() :Server
    {
        return $this->get('server');
    }

    /**
     * @return Client
     * @throws InvalidArgumentException
     */
    public function getClient() :Client
    {
        return $this->get('client');
    }

    /**
     * @param string $property
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }

        throw new InvalidArgumentException(__METHOD__ . ': Undefined Property');
    }
}