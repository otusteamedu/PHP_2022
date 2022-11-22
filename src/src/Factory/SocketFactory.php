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

        if (file_exists($socketFullPath))
            unlink($socketFullPath);

        if (!socket_bind($socket, $socketFullPath))
            throw new Exception("Unable to bind to $socketFullPath");

        return $socket;
    }
}