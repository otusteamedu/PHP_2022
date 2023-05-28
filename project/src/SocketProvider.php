<?php

declare(strict_types=1);

namespace Rehkzylbz\OtusHw7;

class SocketProvider {

    /**
     * 
     * @param string $mode
     * @return ChatSocket
     */
    public static function create_socket(string $mode = ''): ChatSocket {
        if ($mode === 'server') {
            $socket = new ChatSocketServer();
        } elseif ($mode === 'client') {
            $socket = new ChatSocketClient();
        }
        return $socket;
    }

}
