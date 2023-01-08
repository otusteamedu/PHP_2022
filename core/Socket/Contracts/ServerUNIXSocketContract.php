<?php
namespace Otus\Task10\Core\Socket\Contracts;


use Otus\Task10\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task10\Core\Socket\Exceptions\SocketException;

interface ServerUNIXSocketContract{
    public function socket();
    public function bind();
    public function listen();
    public function accept();
    public function read();

}