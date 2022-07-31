<?php

declare(strict_types=1);

namespace Nsavelev\Hw6\Services\Server;

use Nsavelev\Hw6\Services\Config\Config;
use Nsavelev\Hw6\Services\Server\Exceptions\ServerAlreadyStartedException;

class Server
{
    /** @var Server */
    private static Server $server;

    /** @var string */
    private string $pathToSocket = '';

    private function __construct()
    {
        $this->init();
    }

    /**
     * @return Server
     * @throws ServerAlreadyStartedException
     */
    public static function create()
    {
        if (!empty(static::$server)) {
            throw new ServerAlreadyStartedException('Server already started.');
        }

        $server = new self();

        return $server;
    }

    private function init()
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($socket, '/tmp/server.sock');
        socket_listen($socket, 1);

        socket_close($socket);
    }

    public function __destruct()
    {
        unlink('/tmp/server.sock');
    }
}