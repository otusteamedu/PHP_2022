<?php

declare(strict_types=1);

namespace Sveta\Code;

use Throwable;

final class Server
{
    public function run(): void
    {
        try {
            $socket = $this->createUnixSocket();
            $this->send($socket);
        } catch (Throwable $e) {
            print_r('An error has occurred. ' . $e->getMessage());

            return;
        }
    }

    /**
     * @throws \Exception
     */
    public function createUnixSocket(): UnixSocket
    {
        $socket = new UnixSocket();
        $socket->create(dirname(__FILE__) . "/socket/server.sock");

        return $socket;
    }

    public function send(UnixSocket $socket): void
    {
        while (1) {
            $socket->setBlock();
            print_r("Ready to receive..." . PHP_EOL);
            [$buf, $from] = $socket->receive();
            print_r(sprintf('Received "%s" from "%s"', trim($buf), trim($from)) . PHP_EOL);
            $socket->setNonBlock();
            $socket->sendTo($buf, $from);
            print_r("Request processed" . PHP_EOL . PHP_EOL);
        }
    }
}
