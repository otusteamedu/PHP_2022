<?php

namespace Roman\Shum;

use Roman\Shum\Socket\Socket;

class Server
{

    public Socket $socket;

    public function __construct(Socket $socket){
        $this->socket=$socket;
    }

    /**
     * @throws \Exception
     */
    public function start_listen(): void
    {
        $this->socket->bind();
        $this->socket->listen();
        Show::show_message('server waiting message');

        $client = $this->socket->accept();
        while(true){
            $data = $this->socket->recv($client);
            if (strtolower($data) === Socket::EXIT) {
                Show::show_message('server finish chat');
                $this->socket->close($client);
                break;
            }
            Show::show_message('client: '.$data);
            $this->socket->write($data, $client);
        }
        $this->socket->close();
    }

}