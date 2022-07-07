<?php
declare(strict_types=1);

namespace Qween\Php2022\App;

use Exception;

class Server
{
    private Logger $logger;

    private Socket $socket;

    public function __construct(Logger $logger, $socket)
    {
        $this->logger = $logger;
        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    final public function execute(): void
    {
        $this->socket->create(true);

        $this->socket->bind();

        $this->socket->listen();

        $this->logger->print('Waiting for messages...');

        while (true) {
            $this->socket->accept();
            $this->logger->print($this->socket->read());
        }

        $this->socket->closeSocket(true);
    }
}
