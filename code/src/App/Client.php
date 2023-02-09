<?php

declare(strict_types=1);

namespace Kogarkov\Chat\App;

use Generator;
use Kogarkov\Chat\Core\Socket\Client as ClientSocket;

class Client
{
    private $socket;

    public function __construct()
    {
        $this->socket = new ClientSocket();
    }

    public function initialize(): void
    {
        $this->socket->create();
        $this->socket->connect();
    }

    public function run(): \Generator
    {
        yield 'Input message: ';
        while (true) {
            $message = fgets(fopen('php://stdin', 'r'));
            if ($message) {
                $result = $this->socket->write($message);
                if ($result) {
                    yield "$result bytes send to socket \nInput message: ";
                }
            }
        }
    }
}
