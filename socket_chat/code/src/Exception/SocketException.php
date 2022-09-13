<?php

declare(strict_types=1);
namespace Mapaxa\SocketChatApp\Exception;

use Exception;

class SocketException extends Exception
{
    public function __construct($message = "", $code = 404, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Сокет не работает';
        }

        parent::__construct($message, $code, $previous);
    }

}