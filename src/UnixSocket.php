<?php

namespace AKhakhanova\Hw4;

class UnixSocket
{
    public function create(): \Socket
    {
        if (!extension_loaded('sockets')) {
            die('The sockets extension is not loaded.');
        }

        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);

        if (!$socket) {
            die("Unable socket");
        }

        unlink(dirname(__FILE__) . "/server.sock");
        $server_side_sock = dirname(__FILE__) . "/server.sock";
        if (!socket_bind($socket, $server_side_sock)) {
            die("Unable to bind to $server_side_sock");
        }

        return $socket;
    }
}
