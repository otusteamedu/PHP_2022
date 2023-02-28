<?php

namespace Roman\Shum\Socket;

/**
 *
 */
class Socket
{

    /**
     * @var false|resource|\Socket
     */
    public $socket;
    /**
     *
     */
    const SOCKET_FILE='/sock/socket.sock';
    /**
     *
     */
    const EXIT='exit';

    /**
     * @param bool $clear
     */
    public function __construct(bool $clear=false){
        if ($clear && file_exists(self::SOCKET_FILE)) {
            unlink(self::SOCKET_FILE);
        }
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    /**
     * @return void
     */
    public function listen(): void
    {
        socket_listen($this->socket, 5);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function bind(): void
    {
        if(!socket_bind($this->socket, self::SOCKET_FILE)){
            throw new \Exception('Error: bind');
        }
    }

    /**
     * @return bool|\Socket
     */
    public function accept(): bool|\Socket
    {
        return socket_accept($this->socket);
    }

    /**
     * @param $str
     * @param $sock
     * @return void
     * @throws \Exception
     */
    public function write($str, $sock=null): void
    {
        $socket=$sock?:$this->socket;
        if(!socket_write($socket,$str, strlen($str))){
            throw new \Exception('Error: write');
        }
    }

    /**
     * @return false|string
     */
    public function read(): bool|string
    {
        return socket_read($this->socket,512);
    }

    /**
     * @param $sock
     * @return string
     */
    public function recv($sock): string
    {
        $buffer = '';
        socket_recv($sock, $buffer, 512, 0);
        return $buffer;
    }

    /**
     * @return void
     */
    public function connect(): void
    {
        socket_connect($this->socket, self::SOCKET_FILE);
    }

    /**
     * @param $sock
     * @return void
     * @throws \Exception
     */
    public function close($sock=null): void
    {
        $socket=$sock?:$this->socket;
        if(!$socket){
            throw new \Exception('Error: close');
        }
        socket_close($socket);
    }
}