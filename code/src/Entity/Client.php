<?php
declare(strict_types=1);

namespace Otus\SocketApp\Entity;

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
            echo "Введите имя пользователя или 'q' для выхода:  ";
            $this->user = trim(fgets(STDIN));
            if ($this->user === 'q') {
                throw new Exception('Выход выполнен.');
            }
        }

        while (true) {
            $this->logger->display('Напишите сообщение или q для выхода:');

            $message = trim(fgets(STDIN));
            if ($message === 'q') {
                throw new Exception('Выход выполнен.');
            }

            if ($message) {
                $this->socket->create();

                if ($this->socket->connect() === false) {
                    throw new Exception('Не удалось подключиться к сокету');
                } else {
                    $this->socket->send("$this->user:	$message");
                }
            } else {
                throw new Exception('Не передавайте пустое сообщение');
            }
        }
    }
}