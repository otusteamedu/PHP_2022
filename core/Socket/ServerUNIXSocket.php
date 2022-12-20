<?php
namespace Otus\Task07\Core\Socket;


use Otus\Task07\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task07\Core\Socket\Contracts\ServerUNIXSocketContract;
use Otus\Task07\Core\Socket\Exceptions\SocketException;

class ServerUNIXSocket implements ServerUNIXSocketContract {

    private \Socket $socket;
    private \Socket $client;

    public function __construct(private DomainSocketContract $domain){
        $this->domain->initialize();
    }

    public function socket(){
        $this->socket = socket_create(AF_UNIX,SOCK_STREAM,0);
        if(!$this->socket){
           new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function bind(){
        $result = socket_bind($this->socket, $this->domain->getHost());
        if(!$result){
            new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function listen(){
        $result = socket_listen($this->socket);
        if(!$result){
            new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function accept(){

        $this->client = socket_accept($this->socket);
        if(!$this->client){
            new SocketException(socket_strerror(socket_last_error()));
        }
    }
    public function read(){
        $message = socket_read($this->client, 1024);
        if(!$message){
            new SocketException(socket_strerror(socket_last_error()));
        }
        echo $message;
    }


}