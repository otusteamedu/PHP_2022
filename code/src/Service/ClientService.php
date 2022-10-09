<?php

declare(strict_types=1);

namespace Nikolai\Php\Service;

use Nikolai\Php\Factory\SocketFactory;

class ClientService implements ServiceInterface
{
    private SocketFactory $socketFactory;

    public function __construct(private string $socketFile) {
        $this->socketFactory = new SocketFactory($this->socketFile);
    }

    public function run(): void
    {
        $socket = $this->socketFactory->createClientSocket();
        $socket->connect();

        while ($message = trim(fgets(STDIN)))
        {
            $socket->send($message);
            if ($message == self::QUIT) {
                break;
            }

            $response = '';
            $socket->receive($response);
            fwrite(STDOUT, $response . PHP_EOL);
        }

        $socket->close();
    }
}