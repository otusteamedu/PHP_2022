<?php

declare(strict_types=1);

namespace App\Core;

use App\Logger\MyInterfaceLogger;
use RuntimeException;

class Server extends SocketApp
{
    protected $data;
    protected $from;

    public function __construct(?string $sockFile, MyInterfaceLogger $logger)
    {
        if ($sockFile === null) {
            throw new RuntimeException('Не передали имя сокета');
        }

        parent::__construct($sockFile, $logger);
    }

    public function run(): void
    {
        while (true) {

            $this->data = '';
            $this->from = '';

            $this->getRequest();
            $this->sendResponse();
        }
    }

    protected function getRequest(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Не удалось устанавить блокирующий режим на сокете');
        }

        $this->logger->log("Ожидаем ввода \n");

        #Получаем данные из сокета
        $bytes_received = socket_recvfrom($this->socket, $this->data, 65536, 0, $this->from);

        #Проверяем получили ли данные
        if ($bytes_received === -1) {
            throw new RuntimeException('Сообщение не отправлено!');
        }

        $this->logger->log("Полученно '$this->data' из '$this->from'\n");

        $this->data = "Полученно {$bytes_received} bytes";
    }

    protected function sendResponse(): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Не включился неблокирующий режим для файлового дескриптора');
        }

        #Определяем длинну строки, надо для отправки
        $len = strlen($this->data);

        #Отправляем сообщение в сокет
        $bytes_sent = socket_sendto($this->socket, $this->data, $len, 0, $this->from);

        #Проверяем, было ли отправлено сообщение
        if ($bytes_sent === -1) {
            throw new RuntimeException('Сообщение не отправлено!');
        }

        #Проверяем ВСЁ ли сообщение было отправлено
        if ($bytes_sent !== $len) {
            throw new RuntimeException('Сообщение отправлено не корректно (не полностью)');
        }

        $this->logger->log("Запрос обработан\n\n");
    }
}