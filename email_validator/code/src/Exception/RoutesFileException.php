<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Exception;


class RoutesFileException extends \Exception
{

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = 'Routes file not found';
        parent::__construct($message, $code, $previous);
    }
}
