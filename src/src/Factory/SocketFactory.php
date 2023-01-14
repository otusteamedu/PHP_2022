<?php

declare(strict_types=1);

namespace App\Factory;

use Exception;
use Socket;

class SocketFactory
{
    /**
     * @throws Exception
     */
    public static function create(string $socketFullPath): Socket
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket)
            throw new Exception('Unable to create AF_UNIX socket');

        self::loadSocketDir(pathinfo($socketFullPath, PATHINFO_DIRNAME));

        return self::bindSocket($socket, $socketFullPath);
    }

    /**
     * @throws Exception
     */
    private static function loadSocketDir($socketDir): void
    {
        if (!is_dir($socketDir))
            mkdir($socketDir, 0777, true) or
            throw new Exception('Error by creating dir for socket file');
    }

    /**
     * @throws Exception
     */
    private static function bindSocket(Socket $socket, $socketFullPath): Socket
    {
        if (file_exists($socketFullPath))
            unlink($socketFullPath);
        if (!socket_bind($socket, $socketFullPath))
            throw new Exception("Unable to bind to $socketFullPath");

        return $socket;
    }
}