<?php
declare(strict_types=1);

namespace Igor\Php2022;

use \Exception;

class ChatClientUnixSocketTransport implements ChatClientTransportInterface
{
    private string $socketAddr;

    public function __construct(string $socketAddr)
    {
        $this->settings = new Settings();
        $this->socketAddr = $socketAddr;
        $this->connect();
    }

    public function connect()
    {
        if (!($this->sock = \socket_create(AF_UNIX, SOCK_STREAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new Exception("Couldn't create socket: [$errorcode] $errormsg");
        }

        echo "Socket created {$this->socketAddr}\n";

        while (!socket_connect($this->sock , $this->socketAddr))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            echo ("Could not connect: [$errorcode] $errormsg \n");
            sleep(1);
        }

        echo "Connection established \n";
    }

    public function sendMessage(string $message): void
    {
        if( ! socket_send ( $this->sock , $message , strlen($message) , 0))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new Exception("Could not send data: [$errorcode] $errormsg \n");
        }
    }

    public function getReply(): string
    {
        if (socket_recv ($this->sock , $buf , 1024, MSG_WAITFORONE ) === FALSE) {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            throw new Exception("Could not receive data: [$errorcode] $errormsg \n");
        }

        return $buf;
    }
}
