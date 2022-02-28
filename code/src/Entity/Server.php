<?php

namespace KonstantinDmitrienko\App\Entity;

class Server
{
    public function listen($socket)
    {
        $socket->bind();
        $socket->listen();

        echo "Waiting for incoming connections... \n";

        // Accept incoming connection - This is a blocking call
        // $client = socket_accept($socket);
        $client = $socket->accept();

        while (true) {
            // read data from the incoming socket
            // $input = socket_read($client, 1024000);
            $input = $socket->read($client);

            $response = "Sent message: .. {$input}";

            // Display output  back to client
            // socket_write($client, $response);
            $socket->write($response, $client);

            // Display output in server
            echo "Client sent message: {$input}";
        }

//        do {
//            $msgsock = $socket->accept();
//
//            /* Отправляем инструкции. */
//            $msg = "\nДобро пожаловать на тестовый сервер PHP. \n" .
//                "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'.\n";
//            // socket_write($msgsock, $msg, strlen($msg));
//            $socket->write($msg, $msgsock);
//
//            do {
//                //if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
//                if (false === ($buf = $socket->read($msgsock))) {
//                    echo "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($msgsock)) . "\n";
//                    break 2;
//                }
//                if (!$buf = trim($buf)) {
//                    continue;
//                }
//                if ($buf == 'выход') {
//                    break;
//                }
//                if ($buf == 'выключение') {
//                    $socket->close();
//                    break 2;
//                }
//                $talkback = "PHP: Вы сказали '$buf'.\n";
//
//                // socket_write($msgsock, $talkback, strlen($talkback));
//                $socket->write($talkback, $msgsock);
//
//                echo "$buf\n";
//            } while (true);
//
//            // socket_close($msgsock);
//            $socket->close($msgsock);
//        } while (true);
//
//        $socket->close();





//        while(1) {
//            // $socket->setBlock();
//
//            $buf = '';
//            $from = '';
//            echo "Ready to receive...\n";
//            // will block to wait client query
//            $bytes_received = socket_recvfrom($socket, $buf, 65536, 0, $from);
//
//            echo "Received $buf from $from\n";
//
//            $buf .= "->Response"; // process client query here
//
//            // send response
//            // $socket->unBlock();
//
//            // client side socket filename is known from client request: $from
//            $len = strlen($buf);
//            $bytes_sent = socket_sendto($socket, $buf, $len, 0, $from);
//
//            if ($bytes_sent == -1)
//                    die('An error occured while sending to the socket');
//            else if ($bytes_sent != $len)
//                    die($bytes_sent . ' bytes have been sent instead of the ' . $len . ' bytes expected');
//            echo "Request processed\n";
//        }
    }
}
