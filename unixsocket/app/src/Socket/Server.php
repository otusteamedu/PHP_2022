<?php

namespace Unixsocket\App\Socket;

use Socket;

class Server implements SocketService
{
    private const MAX_CONNECTION = 10;
    private const MAX_SIZE_BYTE = 1024;
    private const CLOSE_COMMAND = 'close';

    private Socket $socket;
    private Socket $connect;
    private string $socketFile;

    public function __construct(string $socketFile)
    {
        $this->socketFile = $socketFile;
    }

    public function connect(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->socket, $this->socketFile);
        socket_listen($this->socket, self::MAX_CONNECTION);
    }

    public function run(): void
    {
        while ($this->connect = socket_accept($this->socket)) {

            if (!$message = $this->read()) {
                continue;
            }

            if (trim($message) === self::CLOSE_COMMAND) {
                $closeMessage = 'The connection is closed';
                $this->write($closeMessage);
                $this->close();
                $this->show($closeMessage);
                break;
            }

            $this->write('Сервер получил сообщение: ' . $message);
            $this->show('Сообщение от клиента: ' . $message);
        }
    }

    public function read(): string
    {
        return socket_read($this->connect, self::MAX_SIZE_BYTE);
    }

    public function write(string $message = ''): void
    {
        socket_write($this->connect, $message . "\r\n");
    }

    public function close(): void
    {
        socket_shutdown($this->connect);
        socket_close($this->socket);
        unlink($this->socketFile);
    }

    public function show(string $message): void
    {
        echo "$message\r\n";
    }
}