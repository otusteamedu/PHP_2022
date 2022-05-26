<?php

namespace Nka\OtusSocketChat\Services;

use Nka\OtusSocketChat\Helpers\CliHelper;
use RuntimeException;
use Nka\OtusSocketChat\Socket;

/**
 * @property-read Socket $socket
 */
class SocketClientService
{
    public function __construct(
        private Socket $socket
    ){}

    public function write(string $input): string
    {
        $this->socket->create();
        if (!$this->socket->connect()) {
            throw new RuntimeException('Couldn\'t connect to socket');
        }

        if ($this->socket->write($input)) {
            $buf = '';
            $this->socket->receiveSelf($buf);
            return $buf;
        }
        throw new RuntimeException('Couldn\'t write to socket');
    }
}
