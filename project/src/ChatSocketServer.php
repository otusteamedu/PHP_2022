<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class ChatSocketServer extends ChatSocket {

    /**
     * 
     * @return void
     */
    public function start(): void {
        echo 'server started' . PHP_EOL;
        $this->_socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->_socket, $this->_socket_path);
        socket_listen($this->_socket);
        $accept_socket = socket_accept($this->_socket);
        while (true) {
            $message = socket_read($accept_socket, 65536);
            if ($message === '') {
                continue;
            }
            echo $message . PHP_EOL;
            if ($message === 'exit') {
                break;
            }
        }
        socket_close($this->_socket);
        unlink($this->_socket_path);
        echo 'client/server stopped';
    }

}
