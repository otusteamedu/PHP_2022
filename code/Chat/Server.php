<?php

declare(strict_types=1);

namespace App\Chat;

use RuntimeException;

class Server extends AbstractSocketWorker
{
    protected $data;
    protected $from;

    public function __construct(?string $sockFile = null)
    {
        if ($sockFile === null) {
            throw new RuntimeException('Empty socket filename provided.');
        }

        parent::__construct($sockFile);
    }

    public function run(): void
    {
        while (true) {

            $this->data = '';
            $this->from = '';

            $this->getRequest();
            $this->sendResponse();
        }
    }

    protected function getRequest(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket.');
        }

        echo "Ready to receive...\n";

        $bytes_received = socket_recvfrom($this->socket, $this->data, 65536, 0, $this->from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket.');
        }

        echo "Received '$this->data' from '$this->from'\n";

        $this->data = "Received {$bytes_received} bytes";
    }

    protected function sendResponse(): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Unable to set nonblocking mode for socket.');
        }

        $len = strlen($this->data);
        $bytes_sent = socket_sendto($this->socket, $this->data, $len, 0, $this->from);

        if ($bytes_sent === -1) {
            throw new RuntimeException('An error occurred while sending to the socket.');
        }

        if ($bytes_sent !== $len) {
            throw new RuntimeException($bytes_sent.' bytes have been sent instead of the '.$len.' bytes expected.');
        }

        echo "Request processed\n\n";
    }
}