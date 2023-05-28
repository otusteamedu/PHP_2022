<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class ChatSocketClient extends ChatSocket {

    /**
     * 
     * @return void
     */
    public function start(): void {
        echo 'client started' . PHP_EOL;
        $this->_socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($this->_socket, $this->_socket_path);
        while (true) {
            $input = $this->_get_stdin_input();
            socket_write($this->_socket, $input);
            if ($input === 'exit') {
                socket_close($this->_socket);
                break;
            }
        };
        echo 'client/server stopped';
    }

}
