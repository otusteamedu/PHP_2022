<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Factory\SocketFactory;

class ServerService implements ServiceInterface
{
    private SocketFactory $socketFactory;

    public function __construct(private string $socketFile) {
        $this->socketFactory = new SocketFactory($this->socketFile);
    }

    public function run(): void
    {
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        $socket = $this->socketFactory->createServerSocket();
        $socket->bind();
        $socket->listen();
        $acceptedSocket = $socket->accept();

        while (true) {
            $message = '';
            $receiveBytes = $acceptedSocket->receive($message);

            if ($message) {
                fwrite(STDOUT, $message . PHP_EOL);

                if ($message == self::QUIT) {
                    break;
                }

                $response = 'Received: ' . $receiveBytes . ' bytes' . PHP_EOL;
                $acceptedSocket->send($response);
            }
        }

        $acceptedSocket->close();
        $socket->close();

        unlink($this->socketFile);
    }
}