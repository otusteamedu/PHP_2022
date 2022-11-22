<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Socket;

class ChatSocket
{
    /**
     * @throws Exception
     */
    public static function sendMessage(Socket $socket, string $message, $to): void
    {
        if (!socket_set_nonblock($socket))
            throw new Exception('Unable to set nonblocking mode for socket');

        $bytes_sent = socket_sendto($socket, $message, mb_strlen($message), 0, $to);

        if ($bytes_sent == -1)
            throw new Exception('An error occured while sending to the socket');
    }

    /**
     * @throws Exception
     */
    public static function getMessage(Socket $socket): ?string
    {
        if (!socket_set_block($socket))
            throw new Exception('Unable to set blocking mode for socket');

        $message = null;

        $bytes_received = socket_recvfrom($socket, $message, 65536, 0, $from);

        if ($bytes_received == -1)
            throw new Exception('An error occured while receiving from the socket');

        return $message;
    }
}