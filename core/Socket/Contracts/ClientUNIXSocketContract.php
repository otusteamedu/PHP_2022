<?php
namespace Otus\Task10\Core\Socket\Contracts;

use Otus\Task10\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task10\Core\Socket\Exceptions\SocketException;

interface ClientUNIXSocketContract{
    public function socket(): void;
    public function connect(): void;
    public function write(string $message): void;
}