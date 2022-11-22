<?php

declare(strict_types=1);

namespace App\Command;

use App\Factory\SocketFactory;
use App\Services\ChatSocket;
use Exception;

class ChatCommand implements CommandInterface
{
    public const MODE_SERVER = 'server';
    public const MODE_CLIENT = 'client';

    private string $socketDir;

    private string $socketFullPath;

    private string $mode;

    /**
     * @throws Exception
     */
    public function __construct(string $mode, string $socketDir)
    {
        $this->socketDir = $this->loadSocketDir($socketDir);
        $this->mode = match ($mode) {
            'client' => self::MODE_CLIENT,
            'server' => self::MODE_SERVER,
            default => throw new Exception('Unsupported server mode')
        };

        $this->socketFullPath = $this->socketDir . $this->mode . '.socket';
    }

    /**
     * @throws Exception
     */
    private function loadSocketDir($socketDir): string
    {
        if (!is_dir($socketDir))
            mkdir($socketDir, 0777, true) or
            throw new Exception('Error by creating dir for socket file');

        return $socketDir;
    }

    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $socket = SocketFactory::create($this->socketFullPath);

        echo "Type 'exit' to stop" . PHP_EOL;

        do {
            $message = readline($this->mode . ": ");

            if ($message && $message !== 'exit')
                ChatSocket::sendMessage($socket, $message, $this->socketFullPath);

            $answer = ChatSocket::getMessage($socket, $this->getOtherSideFullPath());

            if ($answer)
                echo $this->getOtherSide() . ': ' . $answer . PHP_EOL;

        } while ($message !== 'exit');

        socket_close($socket);
    }

    /**
     * @throws Exception
     */
    private function getOtherSide(): string
    {
        return match ($this->mode) {
            'client' => self::MODE_SERVER,
            'server' => self::MODE_CLIENT,
            default => throw new Exception('Unsupported server mode')
        };
    }

    /**
     * @throws Exception
     */
    private function getOtherSideFullPath(): string
    {
        return $this->socketDir . $this->getOtherSide() . '.socket';
    }
}