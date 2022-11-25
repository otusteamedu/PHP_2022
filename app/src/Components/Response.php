<?php

declare(strict_types=1);


namespace ATolmachev\MyApp\Components;


use ATolmachev\MyApp\Base\HttpException;

class Response
{
    public function handleHttpError(HttpException $exception): string
    {
        \http_response_code($exception->statusCode);
        return "Ошибка! {$exception->getMessage()}";
    }

    public function reply(string $response): string
    {
        return $response;
    }
}