<?php

declare(strict_types=1);

namespace App\Chat\SocketChat;

use App\Chat\ChatInterface;
use App\Chat\ServerMode;
use App\Chat\SocketChat\Factory\SocketFactory;
use Exception;
use RuntimeException;
use Socket;

class Chat implements ChatInterface
{
    private string $otherSideFullPath;

    private Socket $socket;

    public function __construct(readonly private string $socketDir)
    {
    }

    /**
     * @throws Exception
     */
    public function sendMessage(string $message): bool
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Unable to set nonblocking mode for socket');
        }

        $bytes_sent = socket_sendto($this->socket, $message, mb_strlen($message), 0, $this->otherSideFullPath);

        if ($bytes_sent === -1) {
            throw new RuntimeException('An error occurred while sending to the socket');
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function getMessage(): string
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket');
        }

        $message = '';

        $bytes_received = socket_recvfrom($this->socket, $message, 65536, 0, $from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket');
        }

        return $message;
    }

    /**
     * @throws Exception
     */
    public function start(ServerMode $mode): void
    {
        $this->initSocket($mode);

        if ($mode === ServerMode::SERVER) {
            echo "Waiting for messages...\n";
            $this->startServer($mode);
        }
        if ($mode === ServerMode::CLIENT) {
            echo "Type 'exit' to stop server & exit\n";
            $this->checkOtherSide($mode);
            $this->startClient($mode);
        }
    }

    /**
     * @throws Exception
     */
    private function startServer(ServerMode $mode): void
    {
        do {
            $message = $this->getMessage();

            if ($message) {
                echo $mode->getOtherSide()->name . ': ' . $message . PHP_EOL;
                $this->sendMessage(mb_strlen($message) . ' bytes received');
            }
        } while ($message !== 'exit');
    }

    /**
     * @throws Exception
     */
    private function startClient(ServerMode $mode): void
    {
        do {
            $message = readline($mode->name . ": ");

            if ($message) {
                $this->sendMessage($message);
            }

            $answer = $this->getMessage();

            if ($answer) {
                echo $mode->getOtherSide()->name . ': ' . $answer . PHP_EOL;
            }
        } while ($message !== 'exit');
    }


    public function stop(): void
    {
        socket_close($this->socket);
    }

    /**
     * @throws Exception
     */
    private function initSocket(ServerMode $mode): void
    {
        $this->socket = SocketFactory::create($this->socketDir . $mode->name);
        $this->otherSideFullPath = $this->socketDir . $mode->getOtherSide()->name;
    }

    /**
     * @throws Exception
     */
    private function checkOtherSide(ServerMode $mode): void
    {
        socket_connect($this->socket, $this->otherSideFullPath) or
        throw new Exception("First start the {$mode->getOtherside()->name}\n");
    }
}
