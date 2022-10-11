<?php

namespace Otus\App\Command;

use Otus\Core\Command\CommandInterface;
use Otus\Core\Socket\Socket;

class ClientCommand implements CommandInterface
{
    public function __construct(
        private readonly Socket         $socket,
    )
    {
    }

    public function execute()
    {
        while (true) {
            $this->socket->create()->connect();
            $msg = fgets(STDIN) . PHP_EOL;
            $msg = $this
                ->socket
                ->write($msg)
                ->read();
            $this->socket
                ->close();
            fwrite(STDOUT, $msg . PHP_EOL);
        }
    }
}
