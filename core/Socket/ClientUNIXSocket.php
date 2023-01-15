<?php
namespace Otus\Task10\Core\Socket;

use Otus\Task10\Core\Socket\Contracts\ClientUNIXSocketContract;
use Otus\Task10\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task10\Core\Socket\Exceptions\SocketException;

class ClientUNIXSocket implements ClientUNIXSocketContract {

    private \Socket $socket;

    public function __construct(private readonly DomainSocketContract $domain){}

    public function socket(): void
    {
        $this->socket = socket_create(AF_UNIX,SOCK_STREAM,0);
        if(!$this->socket){
           new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function connect(): void
    {
        $result = socket_connect($this->socket, $this->domain->getHost());
        if(!$result){
            new SocketException(socket_strerror(socket_last_error()));
        }
    }

    public function write(string $message): void
    {
        $result = socket_write($this->socket, $message, strlen($message));
        if(!$result){
            new SocketException(socket_strerror(socket_last_error()));
        }
    }
}