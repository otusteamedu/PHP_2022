<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Components;


use ATolmachev\MyApp\Base\HttpException;

class Response
{
    public function handleHttpError(HttpException $exception): void
    {
        \http_response_code($exception->statusCode);
        echo "Ошибка! {$exception->getMessage()}";
    }

    public function reply(string $response): void
    {
        echo $response;
    }
}