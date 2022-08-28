<?php

declare(strict_types=1);

namespace Nemizar\Php2022;

use Nemizar\Php2022\Chat\ChatApp;
use Nemizar\Php2022\Chat\Socket;

class Client implements ChatApp
{
    private Socket $socket;

    public function __construct()
    {
        $this->socket = new Socket();
    }

    public function start(): void
    {
        $socket = $this->socket->create();

        $sockClientFilePath = __DIR__ . '/client.sock';
        $this->socket->bindSocket($socket, $sockClientFilePath);

        $sockServerSideFilePath = __DIR__ . '/server.sock';

        while (true) {
            $message = \readline('Введите сообщение: ');

            if ($message === 'q') {
                break;
            }

            $this->socket->sendMessage($message, $socket, $sockServerSideFilePath);

            $response = $this->socket->getMessage($socket);
            echo "Получен ответ сервера $response\n";
        }

        \socket_close($socket);
        \unlink($sockClientFilePath);
        echo "Client exits\n";
    }
}
