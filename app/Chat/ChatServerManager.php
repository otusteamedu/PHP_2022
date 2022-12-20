<?php


namespace Otus\Task07\App\Chat;

use Otus\Task07\App\Chat\Contracts\SocketManagerContract;
use Otus\Task07\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task07\Core\Socket\ServerUNIXSocket;

class ChatServerManager implements SocketManagerContract
{
    private ServerUNIXSocket $socket;

    public function __construct(private DomainSocketContract $domain)
    {
        $this->socket = new ServerUNIXSocket($this->domain);
    }

    public function initialize(){
        $this->socket->socket();
        $this->socket->bind();
        $this->socket->listen();
        $this->socket->accept();
    }

    public function start(){
        while (true){
            $this->socket->read();
        }
    }

}