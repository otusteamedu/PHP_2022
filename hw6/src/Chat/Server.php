<?php

declare(strict_types=1);

namespace Veraadzhieva\Hw6\Chat;

use Exception;

class Server
{
    /**
     * @var false|resource|\Socket
     */
    private $socket;

    /**
     * Server.
     *
     * @param string|null $server_config
     *
     * @throws Exception
     */
    public function __construct(?string $server_config)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception ('Сокеты не загружены.');
        }
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!$this->socket) {
            throw new Exception ('Не удается создать сокет.');
        }

        if ($server_config && !socket_bind($this->socket, $server_config)) {
            throw new Exception ("Невозможно подключиться к $server_config");
        }

        if (!socket_set_block($this->socket)) {
            throw new Exception ('Не удается установить режим блокировки для сокета.');
        }
    }

    /**
     * Запуск сервера.
     *
     * @return void
     *
     * @throws Exception
     */
    public function startServer() {
        $buf = '';
        $from = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new Exception ('Ошибка при получении данных из сокета.');
        }
        $buf = "Получено $bytes_received байтов";
        $len = strlen($buf);
        $bytes_sent = socket_sendto($this->socket, $buf, $len, 0, $from);
        if ($bytes_sent == -1) {
            throw new Exception ('Ошибка при отправке.');
        } else if ($bytes_sent != $len) {
            throw new Exception ($bytes_sent . ' байтов было отправлено вместо ' . $len . ' ожидаемых.');
        }
    }
}