<?php

declare(strict_types=1);

namespace App\Infrastructure\Socket;

use App\Application\Service\Logger\LoggerInterface;
use App\Application\Service\Socket\ClientChatInterface;

class ClientSocketWorker implements ClientChatInterface
{
    private SocketWorker $socketWorker;

    public function __construct(
        string $sockFile,
        private readonly string $serverSockFile,
        private readonly LoggerInterface $logger
    ) {
        $this->socketWorker = new SocketWorker($sockFile);
    }

    public function create(): void
    {
        while (true) {

            $this->logger->log("Message: ");

            $msg = trim(fgets(STDIN));

            if ($msg === ':q') {
                $this->logger->log("Goodbye!\n\n");

                return;
            }

            $this->socketWorker->sendData($msg, $this->serverSockFile);

            $request = $this->socketWorker->getData();

            $this->logger->log("Received '".$request['data']."' from '".$request['from']."'\n\n");
        }
    }
}