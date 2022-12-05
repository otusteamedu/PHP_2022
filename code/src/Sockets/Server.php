<?php

namespace Ppro\Hw7\Sockets;

use Ppro\Hw7\Helper\AppContext;

class Server extends Socket
{

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $this->createSocket();
        $this->runSocketServer();
        $this->closeSocketServer();
    }

    /** Прослушивание сообщений клиента и отправка подтверждений о получении клиенту
     * @return void
     */
    private function runSocketServer(): void
    {
        do {
            $buf = '';
            $from = '';
            $receive_bytes = socket_recvfrom($this->socket, $buf, 65536, 0, $from);

            if (!$buf = trim($buf))
                continue;
            if ($buf === "exit")
                break;

            $talkback = "Server received: $receive_bytes bytes.\n";
            socket_sendto($this->socket, $talkback, strlen($talkback),0,$from);
            echo "$buf\n";
        } while (true);
    }

}