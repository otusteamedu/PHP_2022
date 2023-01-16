<?php

declare(strict_types=1);

namespace Sveta\Code;

use Sveta\Code\UnixSocket;
use Throwable;

final class Client
{
    public function run(): void
    {
        try {
            $socket               = new UnixSocket();
            $socketFilePath       = dirname(__FILE__) . "/socket/client.sock";
            $serverSocketFilePath = dirname(__FILE__) . "/socket/server.sock";
            $socket->create($socketFilePath);
            $socket->setNonBlock();

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
        } catch (Throwable $e) {
            print_r('An error has occurred. ' . $e->getMessage());

            return;
        }

        echo "Client exits\n";
    }
}
