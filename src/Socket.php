<?php

namespace Koptev\Hw6;

use Exception;

class Socket
{
    protected string $mainFile;
    protected $socket;

    /**
     * @param array $mainSocketConfig
     * @throws Exception
     */
    public function __construct(array $mainSocketConfig)
    {
        $this->mainFile = $this->getFile($mainSocketConfig['file']);

        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$this->socket) {
            throw new Exception("Unable to create AF_UNIX socket");
        }

        $this->bind($this->mainFile);
    }

    /**
     * @param string $filename
     * @return void
     * @throws Exception
     */
    protected function bind(string $filename)
    {
        if (!socket_bind($this->socket, $filename)) {
            throw new Exception("Unable to bind to $filename");
        }
    }

    /**
     * @param string $message
     * @param string $address
     * @throws Exception
     */
    protected function send(string $message, string $address)
    {
        $len = strlen($message);

        $bytes = socket_sendto($this->socket, $message, $len, 0, $address);

        if ($bytes == -1) {
            throw new Exception('An error occured while sending to the socket');
        } else if ($bytes != $len) {
            throw new Exception($bytes . ' bytes have been sent instead of the ' . $len . ' bytes expected');
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function setBlock()
    {
        if (!socket_set_block($this->socket)) {
            throw new Exception('Unable to set blocking mode for socket');
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function setNonBlock()
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new Exception("Unable to set nonblocking mode for socket");
        }
    }

    /**
     * @return SocketMessage
     * @throws Exception
     */
    protected function receive(): SocketMessage
    {
        $message = '';
        $address = '';

        $bytes = socket_recvfrom($this->socket, $message, 65536, 0, $address);

        if ($bytes == -1) {
            throw new Exception('An error occured while receiving from the socket');
        }

        return SocketMessage::instance([
            'text' => $message,
            'bytes' => $bytes,
            'address' => $address,
        ]);
    }

    /**
     * @param string $filename
     * @param bool $isOldRemove
     * @return void
     */
    protected function getFile(string $filename, bool $isOldRemove = true): string
    {
        $dirname = dirname($filename);

        if (!file_exists($dirname)) {
            mkdir($dirname);
        }

        if ($isOldRemove && file_exists($filename)) {
            unlink($filename);
        }

        return $filename;
    }
}
