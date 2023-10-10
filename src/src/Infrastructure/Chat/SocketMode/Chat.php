<?php

declare(strict_types=1);

namespace App\Infrastructure\Chat\SocketMode;

use App\Application\Chat\ChatInterface;
use App\Application\Chat\Mode;
use App\Application\Message\MessageBuilder;
use App\Domain\Message;
use App\Infrastructure\Chat\SocketMode\Factory\SocketFactory;
use Exception;
use RuntimeException;
use Socket;

abstract class Chat implements ChatInterface
{
    protected string $otherSideFullPath;

    protected Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(readonly private string $socketDir, protected readonly Mode $mode)
    {
    }

    /**
     * @throws Exception
     */
    public function getMessage(): Message
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket');
        }

        $messageBody = '';

        $bytes_received = socket_recvfrom($this->socket, $messageBody, 65536, 0, $from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket');
        }

        return MessageBuilder::build($messageBody);
    }

    /**
     * @throws Exception
     */
    public function sendMessage(Message $message): bool
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Unable to set nonblocking mode for socket');
        }

        $bytes_sent = socket_sendto(
            $this->socket,
            $message->getBody(),
            mb_strlen($message->getBody()),
            0,
            $this->otherSideFullPath
        );

        if ($bytes_sent === -1) {
            throw new RuntimeException('An error occurred while sending to the socket');
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function start(): void
    {
        $this->initSocket();
    }

    public function stop(): void
    {
        socket_close($this->socket);
    }

    /**
     * @throws Exception
     */
    private function initSocket(): void
    {
        $this->socket = SocketFactory::create($this->socketDir . $this->mode->name);
        $this->otherSideFullPath = $this->socketDir . $this->mode->getOtherSide()->name;
    }
}
