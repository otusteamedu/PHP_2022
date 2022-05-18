<?php

use Socket\Client;
use Socket\Server;
use ValueObject\Argument;
use Exception\InvalidArgumentException;

class App
{
    private array $config = [];

    public function __construct()
    {
        $this->config = parse_ini_file(getcwd() . '/config/config.ini', true);
    }

    /**
     * @throws InvalidArgumentException
     * @throws \Exception\InvalidConfigurationException
     */
    public function run()
    {
        $type = $_SERVER['argv'][1] ?? '';
        $argument = new Argument();
        if (!$argument->isValid($type)) {
            throw new InvalidArgumentException("Argument $type is invalid. Must be server or client");
        }

        $socket = null;

        switch ($type) {
            case Argument::SERVER:
                $socket = new Server($this->config[\ValueObject\ConfigKey::SOCKET]);
                break;
            case Argument::CLIENT:
                $socket = new Client($this->config[\ValueObject\ConfigKey::SOCKET]);
                break;
        }

        $socket->connect();
        $socket->run();
    }
}