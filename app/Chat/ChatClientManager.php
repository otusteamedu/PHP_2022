<?php


namespace Otus\Task06\App\Chat;

use Otus\Task06\App\Chat\Contracts\SocketManagerContract;
use Otus\Task06\Core\Socket\ClientUNIXSocket;
use Otus\Task06\Core\Socket\Contracts\DomainSocketContract;

class ChatClientManager implements SocketManagerContract
{
    private ClientUNIXSocket $socket;

    public function __construct(private DomainSocketContract $domain)
    {
        $this->socket = new ClientUNIXSocket($this->domain);
    }

    public function initialize(){
        $this->socket->socket();
        $this->socket->connect();
    }

    public function start(){
        while (true){
            $message = fgets(fopen('php://stdin', 'r'));
            if($message){
                $this->socket->write($message);
            }
        }
    }

}