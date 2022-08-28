<?php

declare(strict_types=1);

namespace Nemizar\Php2022;

use Nemizar\Php2022\Chat\ChatApp;
use Nemizar\Php2022\Chat\Config\Config;
use Nemizar\Php2022\Chat\Socket;

class Client implements ChatApp
{
    private Socket $socket;

    public function __construct(Config $config)
    {
        $this->socket = new Socket($config->getClientSock(), $config->getServerSock());
    }

    public function start(): void
    {
        echo "Введите сообщение для отправки или q для завершения работы\n";
        while (true) {
            $message = \readline('Введите сообщение: ');

            $this->socket->sendMessage($message);

            $response = $this->socket->getMessage();
            echo "Получен ответ сервера $response\n";

            if ($message === 'q') {
                break;
            }
        }

        $this->socket->close();

        echo "Клиент остановлен\n";
    }
}
