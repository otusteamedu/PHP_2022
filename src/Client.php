<?php

namespace AKhakhanova\Hw4;

use Throwable;

class Client
{
    public function run(): void
    {
        try {
            $socket               = new UnixSocket();
            $socketFilePath       = dirname(__FILE__) . "/client.sock";
            $serverSocketFilePath = dirname(__FILE__) . "/server.sock";
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
