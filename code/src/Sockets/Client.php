<?php

namespace Ppro\Hw7\Sockets;

class Client extends Socket
{
    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $this->createSocket();
        $this->runSocketClient();
        $this->closeSocketServer();
    }

    /** Отправка сообщений серверу и получение подтверждений о получении от сервера
     * @return void
     */
    private function runSocketClient(): void
    {

        $serverSideSocketPath = $this->context->getValue('server');
        do {
            $msg = trim(fgets(STDIN));
            if(!empty($msg))
                socket_sendto($this->socket, $msg, strlen($msg), 0, $serverSideSocketPath);
            $buf = '';
            $from = '';
            socket_recvfrom($this->socket, $buf, 65536, 0, $from);
            echo $buf."\n";
        } while (true);
    }
}