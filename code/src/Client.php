<?php

namespace Roman\Shum;

use Roman\Shum\Socket\Socket;

class Client
{

    private Socket $socket;

    public function __construct(Socket $socket){
        $this->socket=$socket;
    }

    /**
     * @throws \Exception
     */
    public function send(): void
    {
        $this->socket->connect();
        while(true){
            $mess=readline('Enter: ');
            $this->socket->write($mess);
            if(strtolower($mess)===Socket::EXIT){
                $this->socket->close();
                break;
            }
            echo $this->socket->read();
        }
    }

}