<?php

namespace Otus\HW6;

use Exception;

class Config
{
    private array $data = [];

    public function __construct(string $path)
    {
        $this->load($path);
    }

    public function get(string $name)
    {
        return $this->data[$name] ?? false;
    }

    protected function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new Exception('Не удалось найти конфигурацию по пути: ' . $path);
        }

        $this->data = parse_ini_file($path);
    }
}
