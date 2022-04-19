<?php

namespace Nka\OtusSocketChat;

class Socket
{
    private \Socket $socket;

    private int $bytes;

    const MAX_BYTES = 2048;

    public function __construct(
        protected string $socketAddress,
        private bool $server = true
    )
    {
    }

    private function beforeCreate(): void
    {
        if ($this->server) {
            if (file_exists($this->socketAddress)) {
                unlink($this->socketAddress);
            }
        }
    }

    public function create(): void
    {
        $this->beforeCreate();
        $this->socket = socket_create(AF_UNIX, STREAM_SOCK_STREAM, 0);
    }

    public function bind(): bool
    {
        return socket_bind($this->socket, $this->socketAddress);
    }

    public function listen(): bool
    {
        return socket_listen($this->socket);
    }

    public function accept(): bool|\Socket
    {
        return socket_accept($this->socket);
    }

    public function receive(\Socket $client, &$buff): bool|int
    {
        return socket_recv($client, $buff, 2048, 0);
    }

    public function receiveSelf(&$buff): bool|int
    {
        return $this->receive($this->socket, $buff);
    }

    public function read(): bool|string
    {
        return socket_read($this->socket, self::MAX_BYTES, PHP_NORMAL_READ);
    }

    public function connect($socket = null): bool
    {
        $socket = $socket ?: $this->socket;
        return socket_connect($socket, $this->socketAddress);
    }


    public function write($data, $socket = null): bool|int
    {
        if (is_null($socket)) {
            return socket_write($this->socket, $data);
        }
        return socket_write($socket, $data);
    }

    public function __destruct()
    {
        socket_close($this->socket);
        if ($this->server) {
            unlink($this->socketAddress);
        }
    }

//    public function listen()
//    {
//        if (socket_listen($this->socket)) {
//            while (true) {
//                $buf = '';
//                $client = socket_accept($this->socket);
//                if ($bytes = socket_recv($client, $buf, 2048, PHP_NORMAL_READ)) {
//                    echo 'Recieved ' . $bytes . ' bytes';
//                }
//            }
//        }
//    }

}
