<?php

namespace KonstantinDmitrienko\App\Entity;

class Client
{
    public function sendMessage($socket)
    {
        $socket->connect();

        while (true) {
            $message = readline("Please enter your message:");

            echo "Send message...";
            $socket->write($message);
            echo "OK.\n";

            echo "Read answer:\n\n";
            echo $socket->read();
            echo "\n\n";
        }


//        $msg = "Message";
//        $len = strlen($msg);
//
//        // at this point 'server' process must be running and bound to receive from serv.sock
//        $bytes_sent = socket_sendto($socket->socket, $msg, $len, 0, '/sock/sock.sock');
//
//        if ($bytes_sent == -1)
//                die('An error occured while sending to the socket');
//        else if ($bytes_sent != $len)
//                die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
//
//        // use socket to receive data
//        if (!socket_set_block($socket->socket))
//                die('Unable to set blocking mode for socket');
//
//        $buf = '';
//        $from = '';
//        // will block to wait server response
//        $bytes_received = socket_recvfrom($socket->socket, $buf, 65536, 0, $from);
//
//        if ($bytes_received == -1)
//                die('An error occured while receiving from the socket');
//        echo "Received $buf from $from\n";
//
//        // close socket and delete own .sock file
//        socket_close($socket);
//        // unlink($client_side_sock);
//        echo "Client exits\n";
    }
}
