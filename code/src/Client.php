<?php

declare(strict_types=1);

namespace Sveta\Code;

use Throwable;

final class Client
{
    public function run(): void
    {
        try {
            $socketFilePath       = dirname(__FILE__) . "/socket/client.sock";
            $serverSocketFilePath = dirname(__FILE__) . "/socket/server.sock";

            $socket = $this->createUnixSocket($socketFilePath);

            $this->send($socket, $socketFilePath, $serverSocketFilePath);
        } catch (Throwable $e) {
            print_r('An error has occurred. ' . $e->getMessage());

            return;
        }

        echo "Client exits\n";
    }

    /**
     * @throws \Exception
     */
    public function send(UnixSocket $socket, string $socketFilePath, string $serverSocketFilePath): void
    {
        $stdin = fopen('php://stdin', 'r');
        $exit  = 0;
        print_r('Enter the message: ');
        while (1) {
            $msg = trim(fgets($stdin));
            if (empty($msg) && $exit) {
                break;
            }

            if (empty($msg)) {
                $exit++;
                print_r('Please type the message or press "Enter" to exit.');
                continue;
            }

            if ($exit) {
                $exit--;
            }

            $socket->sendTo($msg, $serverSocketFilePath);
            $socket->setBlock();
            [$buf, $from] = $socket->receive();
            print_r(sprintf('Message "%s" was successfully sent.', trim($buf)) . PHP_EOL . PHP_EOL);
            print_r('Enter the message: ');
        }

        fclose($stdin);
        $socket->close();
        $socket->unlink($socketFilePath);
    }

    /**
     * @throws \Exception
     */
    public function createUnixSocket(string $socketFilePath): UnixSocket
    {
        $socket = new UnixSocket();
        $socket->create($socketFilePath);
        $socket->setNonBlock();

        return $socket;
    }
}

