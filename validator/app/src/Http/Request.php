<?php

namespace Otus\App\Http;

class Request
{
    /**
     * @throws \Exception
     */
    public function post(string $key): string
    {
        if (!array_key_exists($key, $_POST)) {
            throw new \Exception(sprintf('Ошибка: Параметр %s не найден.', $key), 400);
        }

        return (string)$_POST[$key];
    }
}