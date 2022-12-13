<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Exceptions\ConfigNotFoundException;

class Config
{

    private array $data = [];

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(string $path)
    {
        $this->load($path);
    }

    /**
     * @param string $name
     * @return false|mixed
     */
    public function get(string $name)
    {
        return $this->data[$name] ?? false;
    }

    /**
     * @throws ConfigNotFoundException
     */
    protected function load(string $path): void
    {
        if (!file_exists($path)) {
            throw new ConfigNotFoundException('Could not find config by path: ' . $path);
        }

        $this->data = parse_ini_file($path);
    }
}