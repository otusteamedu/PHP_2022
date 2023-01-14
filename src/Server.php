<?php

namespace AKhakhanova\Hw4;

class Server
{
    public function run(): void
    {
        $socket = new UnixSocket();
        $socket->create(dirname(__FILE__) . "/server.sock");
        while (1) {
            $socket->setBlock();
            print_r("Ready to receive..." . PHP_EOL);
            [$buf, $from] = $socket->receive();
            print_r(sprintf('Received "%s" from "%s"', trim($buf), trim($from)) . PHP_EOL);
            $socket->setNonBlock();
            $socket->sendTo($buf, $from);
            print_r("Request processed" . PHP_EOL.PHP_EOL);
        }
    }
}
