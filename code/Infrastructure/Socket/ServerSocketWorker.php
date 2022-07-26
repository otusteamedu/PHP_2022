<?php

declare(strict_types=1);

namespace App\Infrastructure\Socket;

use App\Application\Service\Logger\LoggerInterface;
use App\Application\Service\Socket\ServerChatInterface;

class ServerSocketWorker implements ServerChatInterface
{
    private SocketWorker $socketWorker;

    public function __construct(string $sockFile, private readonly LoggerInterface $logger)
    {
        $this->socketWorker = new SocketWorker($sockFile);
    }

    public function __destruct()
    {
        $this->socketWorker->delete();
        $this->logger->log(static::class." closed\n\n");
    }

    public function create(): void
    {
        while (true) {

            $this->logger->log("Ready to receive...\n");

            $request = $this->socketWorker->getData();

            $this->logger->log("Received '".$request['data']."' from '".$request['from']."'\n");

            $this->socketWorker->sendData("Received {$request['bytes']} bytes", $request['from']);

            $this->logger->log("Request processed\n\n");
        }
    }
}