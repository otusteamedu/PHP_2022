<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Base;


class HttpException extends \Exception
{
    public int $statusCode;

    public function __construct(
        int $status,
        string $message = null,
        int $code = 0,
        \Exception $previous = null
    )
    {
        $this->statusCode = $status;
        parent::__construct($message, $code, $previous);
    }
}