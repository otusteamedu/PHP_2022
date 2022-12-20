<?php
namespace Otus\Task07\Core\Socket\Contracts;


use Otus\Task07\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task07\Core\Socket\Exceptions\SocketException;

interface ServerUNIXSocketContract{
    public function socket();
    public function bind();
    public function listen();
    public function accept();
    public function read();

}