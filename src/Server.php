<?php

namespace App;

class Server extends Socket
{

    private $connection;

    public function connect()
    {
        $this->bind();
        $this->listen();
    }


    public function run()
    {
        $this->connection = socket_accept($this->socket);

        while (true) {
            $message = $this->read($this->connection);

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
