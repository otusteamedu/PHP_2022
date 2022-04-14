<?php

namespace App;

class SocketFactory
{
    const SERVER_TYPE = 'server';
    const CLIENT_TYPE = 'client';
    const AVAILABLE_TYPES = [self::SERVER_TYPE, self::CLIENT_TYPE];

    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function make(string $type): Socket
    {
        if (!in_array($type, self::AVAILABLE_TYPES, true)) {
            throw new \Exception('Wrong type');
        }

        $socketPath = $this->config->get('socket');

        if ($type === self::SERVER_TYPE) {
            return new Server($socketPath);
        }

        return new Client($socketPath);
    }
}
