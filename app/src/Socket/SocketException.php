<?php

declare(strict_types=1);

namespace Eliasjump\UnixChat\Socket;

use Exception;
use Socket;
use Throwable;

class SocketException extends Exception
{
 public function __construct(Socket $socket, string $message = "", int $code = 0, ?Throwable $previous = null)
 {
     $message .= "\n" . socket_strerror(socket_last_error($socket)) . "\n";
     parent::__construct($message, $code, $previous);
 }
}