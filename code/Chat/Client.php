<?php

declare(strict_types=1);

namespace App\Chat;

use RuntimeException;

class Client extends AbstractSocketWorker
{
    public function __construct(?string $sockFile = null, public ?string $serverSockFile = null)
    {
        if ($sockFile === null || $serverSockFile === null) {
            throw new RuntimeException('Empty socket filename provided.');
        }

        parent::__construct($sockFile);
    }

    public function run(): void
    {
        while (true) {

            echo "Message: ";

            $msg = trim(fgets(STDIN));

            if ($msg === ':q') {
                echo "Goodbye!\n\n";

                return;
            }

            $this->sendRequest($msg);
            $this->getResponse();
        }
    }

    protected function sendRequest(string $msg): void
    {
        if (!socket_set_nonblock($this->socket)) {
            throw new RuntimeException('Unable to set nonblocking mode for socket.');
        }

        $len = strlen($msg);

        $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $this->serverSockFile);

        if ($bytes_sent === -1) {
            throw new RuntimeException('An error occurred while sending to the socket.');
        }

        if ($bytes_sent !== $len) {
            throw new RuntimeException($bytes_sent.' bytes have been sent instead of the '.$len.' bytes expected.');
        }
    }

    protected function getResponse(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket.');
        }

        $bytes_received = socket_recvfrom($this->socket, $data, 65536, 0, $from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket.');
        }

        echo "Received '$data' from '$from'\n\n";
    }
}
