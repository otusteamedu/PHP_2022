<?php

declare(strict_types=1);

namespace App;

use Exception;

class Client
{
    private $user = null;

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
    public function execute(): void
    {
        while (!$this->user) {
            echo "Insert username or 'q' for entry:  ";
            $this->user = trim(fgets(STDIN));
            if ($this->user === 'q') {
                throw new \RuntimeException('Exit executed');
            }
        }

        while (true) {
            $this->logger->display('Write message or q for exit:');

            $message = trim(fgets(STDIN));
            if ($message === 'q') {
                throw new \RuntimeException('Exit executed');
            }

            if ($message) {
                $this->socket->create();

                if ($this->socket->connect() === false) {
                    throw new \RuntimeException('Failed connection to socket');
                } else {
                    $this->socket->send("$this->user:	$message");
                }
            } else {
                throw new \RuntimeException('Empty message');
            }
        }
    }
} 