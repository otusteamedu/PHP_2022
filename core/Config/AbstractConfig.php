<?php

namespace Otus\Core\Config;

use RuntimeException;

abstract class AbstractConfig
{
    protected array $options = [];

    public function __construct(protected readonly string $file)
    {
        if (!file_exists($this->file)) {
            throw new RuntimeException("Configuration file not found!");
        }
        $this->setOptions();
    }

    public function get(string $key)
    {
        if (array_key_exists($key, $this->options)) {
            return  $this->options[$key];
        }
        throw new RuntimeException("configuration with key $key not found");
    }

    abstract protected function setOptions(): void;
}