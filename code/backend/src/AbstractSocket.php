<?php

namespace Socket;

use Socket;

const CONFIG_PATH = '/config/socket.ini';

abstract class AbstractSocket implements SocketInterface
{
    public Socket $socket;
    protected array $config;
    protected string $socketName;
    public string $socketPath;

    public function __construct($loop = true)
    {
        $this->config = parse_ini_file(__DIR__ . CONFIG_PATH);

        $this->getName();

        if ($this->check()) {

            $this->socket = socket_create(
                constant($this->config['DOMAIN']),
                constant($this->config['TYPE']),
                (int)$this->config['PROTOCOL'],
            );

            $this->socketPath = $this->config['PATH'] . $this->socketName;

            if ($loop) {
                $this->openLoop();
            }
        }
    }

    abstract protected function check(): bool;

    abstract protected function openLoop(): void;

    abstract protected function getName(): void;

    protected function setId(): void
    {
        if(!isset($_SESSION['userId'])) {
            $_SESSION['userId'] = time();
        }
    }

}
