<?php

declare(strict_types=1);

namespace App\Core;

use App\Logger\MyInterfaceLogger;
use RuntimeException;

abstract class SocketApp
{
    public $socket;
    public string $sockFile;
    protected MyInterfaceLogger $logger;

    public function __construct(string $sockFile, MyInterfaceLogger $logger)
    {
        $this->logger = $logger;
        $this->sockFile = $sockFile;
        #Запускаем модуль sockets
        if (!extension_loaded('sockets')) {
            throw new RuntimeException('Модуль не загружен.');
        }

        $this->socketCreate();
        $this->socketBind();
    }

    protected function socketCreate(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new RuntimeException('Не удалось создать сокет');
        }
    }

    protected function socketBind(): void
    {
        if (!socket_bind($this->socket, $this->sockFile)) {
            throw new RuntimeException("Не удалось привязать имя к сокету $this->sockFile");
        }
    }

    public function __destruct()
    {
        $this->socketDelete();
    }

    protected function socketDelete(): void
    {
        socket_close($this->socket);
        unlink($this->sockFile);
        $this->logger->log(static::class." класс удален\n\n");
    }

}