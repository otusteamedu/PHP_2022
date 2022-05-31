<?php

declare(strict_types=1);

namespace App\Chat;

use RuntimeException;

abstract class AbstractSocketWorker
{
    public $socket;

    public function __construct(public ?string $sockFile = null)
    {
        if (!extension_loaded('sockets')) {
            throw new RuntimeException('The sockets extension is not loaded.');
        }

        $this->socketCreate();
        $this->socketBind();
    }

    protected function socketCreate(): void
    {
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new RuntimeException('Unable to create AF_UNIX socket');
        }
    }

    protected function socketBind(): void
    {
        if (!socket_bind($this->socket, $this->sockFile)) {
            throw new RuntimeException("Unable to bind to $this->sockFile");
        }
    }

    public function __destruct()
    {
        $this->socketDelete();
    }

    protected function socketDelete(): void
    {
        socket_close($this->socket);
        unlink($this->sockFile);
        echo static::class." closed\n\n";
    }
}