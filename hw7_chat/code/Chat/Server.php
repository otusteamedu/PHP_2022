<?php

/**
 * Server code
 */

declare(strict_types=1);

namespace App\Chat;

use App\Service\Logger\LoggerInterface;
use RuntimeException;

class Server extends SocketApp
{
    protected $data;
    protected $from;

    /**
     * Server consructor
     * @param string|null $sockFile
     * @param LoggerInterface $logger
     */
    public function __construct(?string $sockFile, LoggerInterface $logger)
    {
        if ($sockFile === null) {
            throw new RuntimeException('Empty socket filename provided.');
        }

        parent::__construct($sockFile, $logger);
    }

    /**
     * Run as daemon
     * @return void
     */
    public function run(): void
    {
        while (true) {

            $this->data = '';
            $this->from = '';

            $this->getRequest();
            $this->sendResponse();
        }
    }

    /**
     * Handle request from client
     * @return void
     */
    protected function getRequest(): void
    {
        if (!socket_set_block($this->socket)) {
            throw new RuntimeException('Unable to set blocking mode for socket.');
        }

        $this->logger->log("Ready to receive...\n");

        $bytes_received = socket_recvfrom($this->socket, $this->data, 65536, 0, $this->from);

        if ($bytes_received === -1) {
            throw new RuntimeException('An error occurred while receiving from the socket.');
        }

        $this->logger->log("Received '$this->data' from '$this->from'\n");

        $this->data = "Received {$bytes_received} bytes";
    }

    /**
     * Send response to client
     * @return void
     */
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

        $this->logger->log("Request processed\n\n");
    }
}