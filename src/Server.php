<?php

declare(strict_types=1);

namespace Nemizar\Php2022;

use Nemizar\Php2022\Chat\ChatApp;
use Nemizar\Php2022\Chat\Config\Config;
use Nemizar\Php2022\Chat\Socket;

class Server implements ChatApp
{
    private Socket $socket;

    public function __construct(Config $config)
    {
        $this->socket = new Socket($config->getServerSock(), $config->getClientSock());
    }

    public function start(): void
    {
        while (true) {
            $message = $this->socket->getMessageWithBlock();

            echo "Получено сообщение: $message\n";

            if ($message === 'q') {
                break;
            }

            $response = 'Получено ' . $this->getMessageSize($message) . ' байт';

            $this->socket->sendMessage($response);
        }

        $this->socket->sendMessage('Сервер остановлен\n');
        $this->socket->close();
    }

    private function getMessageSize(string $message): int
    {
        return \strlen($message);
    }
}
