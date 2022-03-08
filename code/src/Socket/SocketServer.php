<?php

namespace KonstantinDmitrienko\App\Socket;

class SocketServer
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
        return $this->socket->create(true);
    }

    /**
     * @return void
     */
    public function bind()
    {
        $this->socket->bind();
    }

    /**
     * @return void
     */
    public function listen()
    {
        $this->socket->listen();
    }

    /**
     * @return resource|\Socket
     */
    public function accept()
    {
        return $this->socket->accept();
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
     * @return array
     */
    public function receive($socket): array
    {
        return $this->socket->receive($socket);
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
