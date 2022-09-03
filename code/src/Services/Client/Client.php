<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Client;

use Nsavelev\Hw6\Services\Client\DTOs\ClientConfigDTO;
use Nsavelev\Hw6\Services\SocketHelper\Factories\SocketHelperFactory;
use Nsavelev\Hw6\Services\SocketHelper\SocketHelper;
use Socket;

class Client
{
    /** @var string */
    private string $socketFile;
    
    /** @var SocketHelper */
    private SocketHelper $socketHelper;

    /** @var Socket */
    private Socket $serverSocket;

    /**
     * @param ClientConfigDTO $clientDto
     */
    public function __construct(ClientConfigDTO $clientDto)
    {
        $this->socketHelper = SocketHelperFactory::getInstance();

        $this->socketFile   = $clientDto->getServerSocketFilePath();

        $serverSocket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        $this->serverSocket = $serverSocket;
    }

    /**
     * @return self
     */
    public function connectToSocket(): self
    {
        socket_connect($this->serverSocket, $this->socketFile);

        return $this;
    }

    /**
     * @param string $message
     * @return bool|int
     */
    public function sendMessage(string $message): bool|int
    {
        $messageLength = mb_strlen($message, 'utf-8');

        $bytesSent = socket_write($this->serverSocket, $message);

        if (empty($bytesSent)) {
            throw new \Exception("Не было передано ни одного байта ($bytesSent)");
        }

        $lastErrorNumber = socket_last_error();

        if ($lastErrorNumber !== SocketHelper::SOCKET_STATUS_SUCCESS) {
            $errorText = socket_strerror($lastErrorNumber);

            throw new \Exception("Socket exception: $errorText");
        }

        return $messageLength;
    }

    /**
     * @param string $message
     * @param Socket $confirmSocket
     * @return string
     */
    public function sendMessageWithConfirm(string $message, Socket $confirmSocket): string
    {
        $messageLength = mb_strlen($message, 'utf-8');

        socket_write($confirmSocket, $message, $messageLength);

        $serverAnswerMessage = $this->listenServerAnswer();

        return $serverAnswerMessage;
    }

    /**
     * @return string
     */
    public function listenServerAnswer(): string
    {
        $serverAnswerMessage  = '';

        $this->socketHelper->listen(
            $this->clientSocket,
            function ($messageData, $message) use (&$serverAnswerMessage)
            {
                $serverAnswerMessage = $message;

                return false;
        });

        return $serverAnswerMessage;
    }

    /**
     * @return void
     */
    public function disconnect(): void
    {
        socket_close($this->serverSocket);
    }
}