<?php

namespace App;

class Client extends Socket
{

    public function connect()
    {
        \socket_connect($this->socket, $this->address);
    }


    public function run()
    {
        while (true) {
            $this->show('Введите сообщение (для выхода введите close):');

            $message = trim(fgets(STDIN));
            if (!$message) {
                continue;
            }

            $this->write($message);
            $this->show(
                $this->read($this->socket)
            );

            if ($message === self::CLOSE_COMMAND) {
                $this->close();
                break;
            }
        }

    }


    public function close()
    {
        socket_close($this->socket);
    }


    public function write(string $text)
    {
        socket_write($this->socket, $text);
    }
}
