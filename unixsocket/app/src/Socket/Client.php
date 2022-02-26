<?php

namespace Unixsocket\App\Socket;

use Socket;

class Client implements SocketService
{
    private const MAX_SIZE_BYTE = 1024;
    private const CLOSE_COMMAND = 'close';

    private Socket $socket;
    private string $socketFile;

    public function __construct(string $socketFile)
    {
        $this->socketFile = $socketFile;
    }

    public function connect(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->socket, $this->socketFile);
    }

    public function run(): void
    {
        while (true) {
            $this->connect();
            $this->show('Новое сообщение (для выхода введите close):');

            if (!$message = fgets(STDIN)) {
                continue;
            }

            $this->write($message);
            $this->show($this->read());

            if (trim($message) === self::CLOSE_COMMAND) {
                $this->close();
                break;
            }
        }
    }

    public function read(): string
    {
        return socket_read($this->socket, self::MAX_SIZE_BYTE);
    }

    public function write(string $message): void
    {
        socket_write($this->socket, $message);
    }

    public function close(): void
    {
        socket_close($this->socket);
    }

    public function show(string $message): void
    {
        echo "$message\r\n";
    }
}
