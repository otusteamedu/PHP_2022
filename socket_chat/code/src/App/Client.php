<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\App;

use Mapaxa\SocketChatApp\Config\SocketConfig;
use Mapaxa\SocketChatApp\Exception\SocketException;
use Mapaxa\SocketChatApp\Message\Message;
use Mapaxa\SocketChatApp\Socket\Socket;

class Client implements AppInterface
{
    private $message;
    private $socket;

    public function __construct()
    {
        $this->socket = new Socket(SocketConfig::SOCKET_FILE_NAME);
        $this->message = new Message();
    }

    public function execute(): void
    {
        $firstMessage = 'Напишите ваше сообщение или нажмите Ctrl + C, чтобы выйти';
        echo $this->message->showMessage($firstMessage);

        while(true) {
            $message = trim(fgets(STDIN)) . PHP_EOL;

            if (empty($message)) {
                $this->message->showMessage('Сообщение пустое. Надо что-то написать.');
            }
            $this->socket->init();

            if ($this->socket->connect()) {
                $this->socket->send($message);

                echo $this->message->showMessage($firstMessage);
            } else {
                throw new SocketException('Не могу подключиться к сокету');
            }
        }
    }
}