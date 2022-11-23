<?php

declare(strict_types=1);

namespace App\Command;

use App\Factory\SocketFactory;
use App\Services\ChatSocket;
use Exception;

class ClientCommand implements CommandInterface
{
    public const SOCKET_NAME = 'client.socket';

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

        echo "Type 'exit' to stop server & exit" . PHP_EOL;

        do {
            $message = readline(self::SOCKET_NAME . ": ");

            if ($message)
                ChatSocket::sendMessage($socket, $message, $this->getOtherSideFullPath());

            $answer = ChatSocket::getMessage($socket);

            if ($answer)
                echo ServerCommand::SOCKET_NAME . ': ' . $answer . PHP_EOL;

        } while ($message !== 'exit');

        socket_close($socket);
    }


    /**
     * @throws Exception
     */
    private function getOtherSideFullPath(): string
    {
        return $this->socketDir . ServerCommand::SOCKET_NAME;
    }
}