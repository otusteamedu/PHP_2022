<?php

declare(strict_types=1);

namespace Nemizar\Php2022;

use Nemizar\Php2022\Chat\ChatApp;
use Nemizar\Php2022\Chat\Socket;

class Server implements ChatApp
{
    private Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    public function start(): void
    {
        $socket = $this->socket->create();

        $sockFilePath = __DIR__ . '/server.sock';
        $this->socket->bindSocket($socket, $sockFilePath);

        $sockClientFilePath = __DIR__ . '/client.sock';

        while (true) {
            $message = $this->socket->getMessageWithBlock($socket);
            echo "Получено сообщение: $message\n";

            $message .= '->Response';

            $this->socket->sendMessage($message, $socket, $sockClientFilePath);
        }
    }
}
