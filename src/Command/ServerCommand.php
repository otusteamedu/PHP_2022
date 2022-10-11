<?php

namespace Otus\App\Command;

use Otus\Core\Command\CommandInterface;
use Otus\Core\Socket\Socket;

class ServerCommand implements CommandInterface
{
    public function __construct(
        private readonly Socket         $socket,
    )
    {
    }

    public function execute()
    {
        $socket = $this->socket
            ->create()
            ->bind()
            ->listen();
        while (true) {
            $message = "";
            $sendBytes = $socket
                ->accept()
                ->recv($message)
            ;
            fwrite(STDOUT, $message);
            $socket->write("Received $sendBytes bytes");
        }
    }
}


