<?php

namespace Socket;

use Exception\InvalidConfigurationException;
use Exception\SocketException;
use JetBrains\PhpStorm\ArrayShape;
use ValueObject\ConfigKey;

class Socket
{
    public const EXIT_COMMAND = 'exit';

    protected $socket;

    protected string $path;
    protected int $bytes;

    public function __construct(
        array $config
    ) {
        if (!$config[ConfigKey::PATH]) {
            throw new InvalidConfigurationException('Path must be set in config.ini.');
        }

        if (!$config[ConfigKey::MAX_BYTES]) {
            throw new InvalidConfigurationException('Max bytes must be set in config.ini.');
        }

        $this->path = $config[ConfigKey::PATH];
        $this->bytes = $config[ConfigKey::MAX_BYTES];

        $this->socket = $this->create();
    }

    /**
     * @return bool|\Socket
     * @throws SocketException
     */
    public function create(): bool|\Socket
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0) ) {
            return $this->socket;
        }

        throw new SocketException('Cannot create a socket.');
    }

    /**
     * @return void
     * @throws
     */
    public function bind(): void
    {
        if (!$this->socket) {
            $this->socket = $this->create();
        }

        if (!socket_bind($this->socket, $this->path)) {
            throw new SocketException('Cannot bind to socket.');
        }
    }

    /**
     * @return void
     * @throws
     */
    public function listen(): void
    {
        if (!socket_listen($this->socket, 5)) {
            throw new SocketException('Cannot listen a socket.');
        }
    }

    /**
     * @return void
     * @throws
     */
    public function connect(): void
    {
        if (!$this->socket) {
            $this->socket = $this->create();
        }

        if (!socket_connect($this->socket, $this->path)) {
            throw new SocketException('Cannot connect to a socket.');
        }
    }

    /**
     * @return \Socket
     * @throws SocketException
     */
    public function accept(): \Socket
    {
        if ($socket = socket_accept($this->socket)) {
            return $socket;
        }

        throw new SocketException('Cannot accept a connection.');
    }

    /**
     * @param $message
     * @return void
     * @throws SocketException
     */
    public function write($message): void
    {
        if (!socket_write($this->socket, $message, strlen($message))) {
            throw new SocketException('Cannot write to a socket.');
        }
    }

    /**
     * @return false|string
     */
    public function read($socket = null): bool|string
    {
        $socket = $socket ?: $this->socket;

        return socket_read($socket, $this->bytes);
    }

    /**
     * @return array
     * @throws
     */
    #[ArrayShape(['message' => "string", 'bytes' => "int"])] public function receive(): array
    {
        $buffer = '';

        if ($bytes = socket_recv($this->socket, $buffer, $this->bytes, 0)) {
            return [
                'message' => $buffer,
                'bytes' => $bytes
            ];
        }

        throw new SocketException('Cannot read a message.');
    }

    public function close(): void
    {
        if (!$this->socket) {
            throw new SocketException('No socket for closing.');
        }

        socket_close($this->socket);
    }
}
