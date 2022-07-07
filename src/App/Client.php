<?php
declare(strict_types=1);

namespace Qween\Php2022\App;

use Exception;

class Client
{
    private $user = null;

    private Logger $logger;

    private Socket $socket;

    public function __construct(Logger $logger, Socket $socket)
    {
        $this->logger = $logger;
        $this->socket = $socket;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        if ($this->user === 'exit') {
            throw new Exception('The output is completed.');
        }

        while (!$this->user) {
            echo "Enter the username or 'exit' to log out:  ";
            $this->user = trim(fgets(STDIN));
        }

        while (true) {
            $this->logger->print('Write a message or a "exit" to exit:');

            $message = trim(fgets(STDIN));
            if ($message === 'exit') {
                throw new Exception('The output is completed.');
            }

            if (!$message) {
                throw new Exception('The message should not be empty');
            }

            $this->socket->create();

            if (!$this->socket->connect()) {
                throw new Exception('Failed connection');
            }

            $this->socket->send("{$this->user}:	{$message}");
        }
    }
}
