<?php

namespace KonstantinDmitrienko\App\Socket;

/**
 * Class for working with unix sockets
 */
class Socket
{
    /**
     * @var false|resource|\Socket
     */
    public $socket;

    /**
     * @var string
     */
    protected string $socketFile = '';

    /**
     * @var int
     */
    protected int $maxBytes = 0;

    /**
     * @var string
     */
    public string $exitCommand = 'exit';

    /**
     * @param array $configs
     */
    public function __construct(array $configs)
    {
        if (!$configs['path'] || !$configs['max_bytes']) {
            throw new \InvalidArgumentException('Error: Missing socket path or max_bytes in configs parameter');
        }

        $this->socketFile = $configs['path'];
        $this->maxBytes   = $configs['max_bytes'];
    }

    /**
     * @param bool $removeSocketFile
     *
     * @return bool|\Socket
     */
    public function create(bool $removeSocketFile = false): bool|\Socket
    {
        if ($removeSocketFile && file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }

        if ($this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0) ) {
            return $this->socket;
        }

        throw new \RuntimeException('Error: Socket did not created.');
    }

    /**
     * @return void
     */
    public function bind()
    {
        if (!socket_bind($this->socket, $this->socketFile)) {
            throw new \RuntimeException('Error: Cannot bind to socket.');
        }
    }

    /**
     * @return void
     */
    public function listen()
    {
        if (!socket_listen($this->socket, 5)) {
            throw new \RuntimeException('Error: Cannot listen the socket.');
        }
    }

    /**
     * @return void
     */
    public function connect()
    {
        if (!socket_connect($this->socket, $this->socketFile)) {
            throw new \RuntimeException('Error: Cannot connect to socket.');
        }
    }

    /**
     * @return resource|\Socket
     */
    public function accept()
    {
        if ($socket = socket_accept($this->socket)) {
            return $socket;
        }

        throw new \RuntimeException('Error: Cannot accept connection to socket.');
    }

    /**
     * @param $message
     * @param $socket
     *
     * @return void
     */
    public function write($message, $socket = null)
    {
        $socket = $socket ?: $this->socket;

        if (!socket_write($socket, $message, strlen($message))) {
            throw new \RuntimeException('Error: Cannot write to socket.');
        }
    }

    /**
     * @param $socket
     *
     * @return false|string
     */
    public function read($socket = null)
    {
        $socket = $socket ?: $this->socket;
        return socket_read($socket, $this->maxBytes);
    }

    /**
     * @param $socket
     *
     * @return array
     */
    public function receive($socket): array
    {
        $buffer = '';
        $socket = $socket ?: $this->socket;

        if ($bytes = socket_recv($socket, $buffer, $this->maxBytes, 0)) {
            return ['message' => $buffer, 'bytes' => $bytes];
        }

        throw new \RuntimeException('Error: Message could not be read');
    }

    /**
     * @param $socket
     *
     * @return void
     */
    public function close($socket = null): void
    {
        $socket = $socket ?: $this->socket;

        if (!$socket) {
            throw new \RuntimeException('Error: Missing socket for closing.');
        }

        socket_close($socket);
    }
}
