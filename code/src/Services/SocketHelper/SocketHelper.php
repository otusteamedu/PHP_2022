<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\SocketHelper;

use Nsavelev\Hw6\Services\SocketHelper\Exceptions\SocketErrorException;
use Nsavelev\Hw6\Services\SocketHelper\Interfaces\SocketHelperInterface;
use Socket;

class SocketHelper implements SocketHelperInterface
{
    /** @var int */
    public const SOCKET_STATUS_SUCCESS = 0;

    /** @var int */
    private const SOCKET_CLIENT_DISCONNECTED = 0;

    /**
     * @param string $socketFilePath
     * @return Socket
     */
    public function create(string $socketFilePath): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);

        if (realpath($socketFilePath)) {
            unlink($socketFilePath);
        }

        socket_bind($socket, $socketFilePath);

        return $socket;
    }

    /**
     * @param string $socketFilePath
     * @return Socket
     */
    public function connect(string $socketFilePath): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_SEQPACKET, 0);
        $this->checkSocketError();

        socket_connect($socket, $socketFilePath);
        $this->checkSocketError();

        return $socket;
    }

    /**
     * @param Socket $socket
     * @param callable $messageHandler
     * @return void
     */
    public function listen(Socket $socket, callable $messageHandler): void
    {
        socket_listen($socket, 1);
        $this->checkSocketError();

        $isStopListening = false;

        while ($isStopListening !== true)
        {
            /** @var Socket|false $newConnect */
            $newConnect = socket_accept($socket);
            $this->checkSocketError();

            if (!empty($newConnect))
            {
                while($isStopListening !== true) {

                    $messageOption = socket_get_option($newConnect, SOL_SOCKET, SO_RCVBUF);
                    $this->checkSocketError();

                    $message = socket_read($newConnect, $messageOption);
                    $this->checkSocketError();

                    $clientIsDisconnected = $this->checkSocketIsDisconnectedByMessage($message);

                    if ($clientIsDisconnected) {
                        break;
                    }

                    $isContinueListening = $messageHandler($messageOption, $message);

                    if (!$isContinueListening) {
                        $isStopListening = true;
                    }
                }
            }
        }
    }

    /**
     * @return void
     * @throws SocketErrorException
     */
    public function checkSocketError(): void
    {
        $lastErrorNumber = socket_last_error();

        if ($lastErrorNumber !== SocketHelper::SOCKET_STATUS_SUCCESS) {
            $errorText = socket_strerror($lastErrorNumber);

            throw new SocketErrorException("Socket exception: $errorText");
        }
    }

    /**
     * @param string $message
     * @return bool
     */
    private function checkSocketIsDisconnectedByMessage(string $message): bool
    {
        $isDisconnected = false;

        if (empty($message)) {
            $lastError = socket_last_error();

            if ($lastError === self::SOCKET_CLIENT_DISCONNECTED) {
                $isDisconnected = true;
            }
        }

        return $isDisconnected;
    }
}