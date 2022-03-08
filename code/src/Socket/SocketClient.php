<?php

namespace KonstantinDmitrienko\App\Socket;

class SocketClient
{
    /**
     * @var Socket
     */
    private Socket $socket;

    /**
     * @var string
     */
    public string $exitCommand = '';

    public function __construct($config)
    {
        $this->socket      = new Socket($config);
        $this->exitCommand = $this->socket->exitCommand;
    }

    /**
     * @return bool|\Socket
     */
    public function create(): bool|\Socket
    {
        return $this->socket->create();
    }

    /**
     * @return void
     */
    public function connect()
    {
        $this->socket->connect();
    }

    /**
     * @param $message
     * @param $socket
     *
     * @return void
     */
    public function write($message, $socket = null)
    {
        $this->socket->write($message, $socket);
    }

    /**
     * @param $socket
     *
     * @return false|string
     */
    public function read($socket = null)
    {
        return $this->socket->read($socket);
    }

    /**
     * @param $socket
     *
     * @return void
     */
    public function close($socket = null): void
    {
        $this->socket->close($socket);
    }
}
