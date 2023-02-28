<?php

namespace Email\App\Http;

class Request
{

    /**
     * @throws \Exception
     */
    public function post(string $key): string
    {
        $this->validate($key, $_POST);

        return (string)$_POST[$key];
    }

    /**
     * @throws \Exception
     */
    public function get(string $key): string
    {
        $this->validate($key, $_GET);

        return (string)$_GET[$key];
    }

    /**
     * @throws \Exception
     */
    private function validate(string $key, array $values): void
    {
        if (!array_key_exists($key, $values)) {
            throw new \Exception(sprintf('Ошибка: Параметр %s не найден.', $key), 400);
        }
    }
}