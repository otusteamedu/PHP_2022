<?php

declare(strict_types=1);

namespace Veraadzhieva\Hw6\Chat;

use Exception;

class Client
{
    /**
     * @var false|resource|\Socket
     */
    private $socket;
    private $client_config;
    private $server_config;

    /**
     * Client.
     *
     * @param string|null $client_config
     * @param string|null $server_config
     *
     * @throws Exception
     */
    public function __construct(?string $client_config, ?string $server_config)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception ('Сокеты не загружены.');
        }
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if (!$this->socket) {
            throw new Exception ('Не удается создать сокет.');
        }
        $this->client_config = $client_config;
        $this->server_config = $server_config;

    }

    /**
     * Запуск клиента.
     *
     * @return void
     * @throws Exception
     */
    public function startClient(): void
    {
        $msg = trim(fgets(STDIN));
        $len = strlen($msg);
        if ($this->server_config) {
            $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $this->server_config);
            if ($bytes_sent == -1) {
                throw new Exception ('Ошибка при отправке.');
            } else if ($bytes_sent != $len) {
                throw new Exception ($bytes_sent . ' байтов было отправлено вместо  ' . $len . ' ожидаемых');
            }
        }

        if (!socket_set_block($this->socket)) {
            throw new Exception ('Не удается установить режим блокировки для сокета.');
        }

        $buf = '';
        $from = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new Exception ('Ошибка при получении из сокета.');
        }

        socket_close($this->socket);
        unlink($this->client_config);
    }
}