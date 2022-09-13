<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\Client;

use Exception;
use Mapaxa\SocketChatApp\Config\SocketConfig;
use Mapaxa\SocketChatApp\Exception\SocketException;
use Mapaxa\SocketChatApp\Message\Message;
use Mapaxa\SocketChatApp\Socket\Socket;

class App
{
    private $message;
    private $socket;

    public function __construct()
    {
        $this->socket = new Socket(SocketConfig::SocketFileName);
        $this->message = new Message();
    }

    public function execute(): void
    {
        $firstMessage = 'Напишите ваше сообщение или нажмите Ctrl + C, чтобы выйти';
        $this->message->showMessage($firstMessage);

        while(true) {
            $message = trim(fgets(STDIN));

            if (empty($message)) {
                $this->message->showMessage('Сообщение пустое. Надо что-то написать.');
            }
            $this->socket->init();

            if ($this->socket->connect()) {
                $this->socket->send($message);

                $this->message->showMessage($firstMessage);
            } else {
                throw new SocketException('Не могу подключиться к сокету');
            }
        }
    }
}