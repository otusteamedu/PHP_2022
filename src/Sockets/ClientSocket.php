<?php

namespace Otus\HW6\Sockets;

use Generator;
use Exception;

class ClientSocket extends Socket
{
    private string $server;
    public function __construct(string $file, string $server)
    {
        try {
            parent::__construct($file);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }

        $this->server = $server;
    }

    public function run(): Generator
    {
        while (true) {
            $message = trim(fgets(STDIN));
            $this->send($message, $this->server);
            $response = $this->receive();

            yield $response['text'];
        }
    }
}
