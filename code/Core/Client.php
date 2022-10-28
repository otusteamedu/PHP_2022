<?php

declare(strict_types=1);

namespace App\Core;

use App\Logger\MyInterfaceLogger;
use RuntimeException;

class Client extends SocketApp
{
    public ?string $serverSockFile;

    public function __construct(?string $sockFile, ?string $serverSockFile, MyInterfaceLogger $logger)
    {
        $this->serverSockFile = $serverSockFile;
        if ($sockFile === null || $serverSockFile === null) {
            throw new RuntimeException('Не передали имя сокета');
        }

        parent::__construct($sockFile, $logger);
    }

    public function run(): void
    {
        while (true) {

            $this->logger->log("Сообщение: ");

            $msg = fgets(STDIN);

            if ($msg === ':flugegeheimen') {
                $this->logger->log("Выход!\n\n");

                return;
            }

            $this->sendRequest($msg);
            $this->getResponse();
        }
    }

    protected function sendRequest(string $msg): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Не включился неблокирующий режим для файлового дескриптора');
        }

        #Определяем длинну строки, надо для отправки
        $len = strlen($msg);

        #Отправляем сообщение в сокет
        $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $this->serverSockFile);

        #Проверяем, было ли отправлено сообщение
        if ($bytes_sent === -1) {
            throw new RuntimeException('Сообщение не отправлено!');
        }

        #Проверяем ВСЁ ли сообщение было отправлено
        if ($bytes_sent !== $len) {
            throw new RuntimeException('Сообщение отправлено не корректно (не полностью)');
        }
    }

    protected function getResponse(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Не удалось устанавить блокирующий режим на сокете');
        }

        #Получаем данные из сокета
        $bytes_received = socket_recvfrom($this->socket, $data, 65536, 0, $from);

        #Проверяем получили ли данные
        if ($bytes_received === -1) {
            throw new RuntimeException('Данные из сокета не получены');
        }

        $this->logger->log("Полученно '$data' из '$from'\n\n");
    }

}