<?php

namespace Ppro\Hw7\Sockets;

use Ppro\Hw7\Helper\AppContext;

abstract class Socket
{
    protected AppContext $context;
    protected \Socket $socket;
    protected string $type;
    protected string $socketPath;

    public function __construct(AppContext $context)
    {
        $this->context = $context;
        $this->type = $context->getValue('type');;
        $this->socketPath = $context->getValue($this->type);
        if(empty($this->socketPath))
            throw new \Exception("Not find path in config for ".$this->type);
    }

    /** Создание и привязка файла сокета
     * @param string $type
     * @return void
     * @throws \Exception
     */
    protected function createSocket(): void
    {
        if(file_exists($this->socketPath))
            unlink($this->socketPath);
        if (!extension_loaded('sockets'))
            throw new \Exception('The sockets extension is not loaded.');

        if (($this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0)) === false)
            throw new \Exception("socket_create(): " . socket_strerror(socket_last_error()));

        if (socket_bind($this->socket, $this->socketPath) === false)
            throw new \Exception("socket_bind(): " . socket_strerror(socket_last_error($this->socket)));
    }

    abstract protected function run();


    /** Закрытие сокета, удаление файла сокета
     * @param
     * @return void
     */
    protected function closeSocketServer(): void
    {
        socket_close($this->socket);
        unlink($this->socketPath);
    }


}