<?php

declare(strict_types=1);

namespace App\Command;

use App\Factory\SocketFactory;
use App\Services\ChatSocket;
use Exception;

class ServerCommand implements CommandInterface
{
    public const SOCKET_NAME = 'server.socket';

    private string $socketDir;

    private string $socketFullPath;

    /**
     * @throws Exception
     */
    public function __construct(string $socketDir)
    {
        $this->socketDir = $socketDir;
        $this->socketFullPath = $this->socketDir . self::SOCKET_NAME;
    }


    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $socket = SocketFactory::create($this->socketFullPath);

        do {
            $message = ChatSocket::getMessage($socket);

            if ($message)
            {
                echo ClientCommand::SOCKET_NAME . ': ' . $message . PHP_EOL;
                ChatSocket::sendMessage($socket, mb_strlen($message) . ' bytes received', $this->getOtherSideFullPath());
            }

        } while ($message !== 'exit');

        socket_close($socket);
    }

    /**
     * @throws Exception
     */
    private function getOtherSideFullPath(): string
    {
        return $this->socketDir . ClientCommand::SOCKET_NAME;
    }
}