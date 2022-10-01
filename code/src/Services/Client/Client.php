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

    /** @var ClientConfigDTO */
    private ClientConfigDTO $clientConfigDto;

    /**
     * @param ClientConfigDTO $clientConfigDto
     */
    public function __construct(ClientConfigDTO $clientConfigDto)
    {
        $this->socketHelper     = SocketHelperFactory::getInstance();
        $this->socketFile       = $clientConfigDto->getServerSocketFilePath();
        $this->clientConfigDto  = $clientConfigDto;

        $serverSocket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        $this->serverSocket = $serverSocket;
    }

    /**
     * @return self
     */
    public function connectToSocket(): self
    {
        socket_connect($this->serverSocket, $this->socketFile);
        $this->socketHelper->checkSocketError();

        return $this;
    }

    /**
     * @param string $message
     * @return self
     * @throws \Exception
     */
    public function sendMessage(string $message): self
    {
        $bytesSent = socket_write($this->serverSocket, $message);

        if (empty($bytesSent)) {
            throw new \Exception("Не было передано ни одного байта ($bytesSent)");
        }

        $this->socketHelper->checkSocketError();

        return $this;
    }

    /**
     * @param string $message
     * @return string
     */
    public function sendMessageWithConfirm(string $message): string
    {
        $socketAnswerPath = $this->clientConfigDto->getAnswerSocketFilePath();
        $confirmSocket = $this->socketHelper->create($socketAnswerPath);

        socket_write($this->serverSocket, $message);

        $this->socketHelper->checkSocketError();

        $serverAnswerMessage = $this->listenServerAnswer($confirmSocket);

        socket_close($confirmSocket);
        unlink($socketAnswerPath);

        $this->socketHelper->checkSocketError();

        return $serverAnswerMessage;
    }

    /**
     * @param Socket $answerSocket
     * @return string
     */
    public function listenServerAnswer(Socket $answerSocket): string
    {
        $serverAnswerMessage  = '';

        $this->socketHelper->listen(
            $answerSocket,
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
        $this->socketHelper->checkSocketError();
    }
}