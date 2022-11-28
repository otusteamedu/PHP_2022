<?php


namespace Study\Chat\Socket;

use Exception;
use Socket;


class SocketException extends Exception
{
    public function __construct(Socket $socket, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $message .= "\n" . socket_strerror(socket_last_error($socket)) . "\n";
        parent::__construct($message, $code, $previous);
    }
}