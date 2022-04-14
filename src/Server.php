<?php

namespace App;

class Server extends Socket
{

    private $connection;

    public function connect()
    {
        \socket_bind($this->socket, $this->address);
        \socket_listen($this->socket);
    }


    public function run()
    {
        $this->connection = socket_accept($this->socket);

        while (true) {
            $message = $this->read();

            if (!$message) {
                continue;
            }

            if (trim($message) === self::CLOSE_COMMAND) {
                $closeMessage = 'Соединение закрыто';
                $this->write($closeMessage);
                $this->close();
                $this->show($closeMessage);
                break;
            }

            $this->write('Сервер получил сообщение: ' . $message);
            $this->show('Сообщение от клиента: ' . $message);
        }
    }


    public function read()
    {
        return socket_read($this->connection, 1024);
    }


    public function write(string $text)
    {
        socket_write($this->connection, $text);
    }


    public function close(): void
    {
        socket_shutdown($this->connection);
        socket_close($this->socket);
        unlink($this->address);
    }
}
