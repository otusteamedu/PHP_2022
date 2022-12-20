<?php
namespace Otus\Task07\Core\Socket\Contracts;

use Otus\Task07\Core\Socket\Contracts\DomainSocketContract;
use Otus\Task07\Core\Socket\Exceptions\SocketException;

interface ClientUNIXSocketContract{
    public function socket(): void;
    public function connect(): void;
    public function write(string $message): void;
}