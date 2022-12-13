<?php

namespace Dkozlov\App;

use Dkozlov\App\Exceptions\ConfigNotFoundException;
use Dkozlov\App\Exceptions\ModeUndefinedException;
use Dkozlov\App\Sockets\Client;
use Dkozlov\App\Sockets\Exceptions\BindFailedException;
use Dkozlov\App\Sockets\Exceptions\CreateFailedException;
use Dkozlov\App\Sockets\Server;
use Dkozlov\App\Sockets\Socket;

class App
{

    public const SERVER = 'server';

    public const CLIENT = 'client';

    private Config $config;

    private string $mode;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(string $mode)
    {
        $this->config = new Config(__DIR__ . '/../config/config.ini');
        $this->mode = $mode;
    }

    /**
     * @throws ModeUndefinedException
     * @throws BindFailedException
     * @throws CreateFailedException
     */
    public function run(): void
    {
        $socket = $this->buildSocket();

        foreach ($socket->run() as $message) {
            echo $message . PHP_EOL;
        }
    }

    /**
     * @throws ModeUndefinedException
     * @throws BindFailedException
     * @throws CreateFailedException
     */
    protected function buildSocket(): Socket
    {
        switch ($this->mode) {
            case self::CLIENT:
                return new Client($this->config->get('client'), $this->config->get('server'));
            case self::SERVER:
                return new Server($this->config->get('server'));
            default:
                throw new ModeUndefinedException('Undefined app mode: ' . $this->mode);
        }
    }
}