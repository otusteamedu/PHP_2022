<?php

namespace AKhakhanova\Hw4;

class Server
{
    public function run()
    {
        $socket = (new UnixSocket())->create();
        while (1) { // server never exits
            if (!socket_set_block($socket)) {
                die('Unable to set blocking mode for socket');
            }
            $buf  = '';
            $from = '';
            echo "Ready to receive...\n";
// will block to wait client query
            $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
            if ($bytes_received == -1) {
                die('An error occured while receiving from the socket');
            }
            echo "Received $buf from $from\n";

            $buf .= "->Response"; // process client query here

// send response
            if (!socket_set_nonblock($socket)) {
                die('Unable to set nonblocking mode for socket');
            }
// client side socket filename is known from client request: $from
            $len        = strlen($buf);
            $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);
            if ($bytes_sent == -1) {
                die('An error occured while sending to the socket');
            } else if ($bytes_sent != $len) {
                die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
            }
            echo "Request processed\n";
        }
    }
}
