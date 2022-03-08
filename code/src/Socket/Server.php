<?php

declare(strict_types=1);

namespace masteritua\Socket;

class Server
{
    private Log $logger;

    private Socket $socket;

    public function __construct()
    {
        $configurator = new Config();
        $this->logger = new Log();
        $this->socket = new Socket($configurator->getParam('SOCKET_FILE'));
    }

    /**
     * @throws Exception
     */
    final public function execute(): void
    {
        $this->socket->create(true);

        $this->socket->bind();

        $this->socket->listen();

        $this->logger->display('Waiting for message (For exit click on CTRL+C)...');

        while (true) {
            $this->socket->accept();
            $this->logger->display($this->socket->read());
        }

        $this->socket->closeSocket(true);
    }
}