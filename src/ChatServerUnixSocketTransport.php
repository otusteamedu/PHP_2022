<?php
declare(strict_types=1);

namespace Igor\Php2022;

use Exception;
use Socket;

class ChatServerUnixSocketTransport implements ChatServerTransportInterface
{
    private string $socketAddr;

    private false|Socket $client = false;

    public function __construct(string $socketAddr)
    {
        $this->socketAddr = $socketAddr;
        $this->createServer();
    }

    /**
     * @throws Exception
     */
    private function createServer(): void
    {
        if (!($sock = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
            $errorCode = socket_last_error();
            $errorMsg = socket_strerror($errorCode);

            throw new Exception("Couldn't create socket: [$errorCode] $errorMsg \n");
        }

        echo "Socket created \n";

        if (!socket_bind($sock, $this->socketAddr)) {
            $errorCode = socket_last_error();
            $errorMsg = socket_strerror($errorCode);

            throw new Exception("Could not bind socket : [$errorCode] $errorMsg \n");
        }

        $this->sock = $sock;
        echo "Socket bind OK \n";

        while (!socket_listen ($this->sock , 10))
        {
            $errorCode = socket_last_error();
            $errorMsg = socket_strerror($errorCode);

            echo "Could not listen on socket : [$errorCode] $errorMsg \n";

            sleep(1);
        }
    }

    private function acceptConnection()
    {
        echo "Waiting for incoming connections... \n";

        //Accept incoming connection - This is a blocking call
        $this->client = socket_accept($this->sock);
    }

    public function getMessage(): string
    {
        if (!$this->client) {
            $this->acceptConnection();
        }

        return socket_read($this->client, 1024000);
    }

    public function sendMessage(string $message): void
    {
        if (!$this->client) {
            $this->acceptConnection();
        }

        socket_write($this->client, $message);
        echo ":::: message sent\n";
    }
}