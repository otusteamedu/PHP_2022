<?php
declare(strict_types=1);

namespace Otus\SocketApp\Entity;

use Exception;

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

        $this->logger->display('Ожидание сообщений (Для выхода нажмите CTRL+C)...');

        while (true) {
            $this->socket->accept();
            $this->logger->display($this->socket->read());
        }

        $this->socket->closeSocket(true);
    }
}