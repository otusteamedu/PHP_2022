<?php

namespace Core\Base;

use Core\Helpers\Console;
use Core\Services\SocketService;
use Core\Exceptions\InvalidArgumentException;

class Client extends SocketService
{
    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function sendMessage() :void
    {
        $this->socket->socketCreate(false)
                     ->socketConnect();

        while(true){
            Console::show('Write your a message or (exit, CTRL+C) to exit:', false);
            $msg = Console::readLine();

            $this->socket->socketWrite($msg);
            if ($msg === 'exit') {
                Console::show('Client socket close connection', false);
                break;
            }

            Console::show($this->socket->socketRead());
        }

        $this->socket->socketClose();
    }
}