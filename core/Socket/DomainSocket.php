<?php
namespace Otus\Task10\Core\Socket;

use Otus\Task10\Core\Socket\Contracts\DomainSocketContract;

class DomainSocket implements DomainSocketContract {

    public function __construct(private string $host){}

    public function getHost(): string{
        return $this->host;
    }

    public function initialize()
    {
       if($this->existsHost()){
           $this->remveHost();
       }
    }

    private function existsHost(): bool{
        return file_exists($this->host);
    }
    private function remveHost(): void{
        unlink($this->getHost());
    }

}