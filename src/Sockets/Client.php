<?php

namespace Dkozlov\App\Sockets;

class Client extends Socket
{

    private string $server;

    public function __construct(string $file, string $server)
    {
        parent::__construct($file);

        $this->server = $server;
    }

    public function run(): void
    {
        while (true) {
            $message = trim(fgets(STDIN));

            $this->send($message, $this->server);

            $response = $this->receive();
            
            echo $response['text'] . PHP_EOL;
        }
    }
}