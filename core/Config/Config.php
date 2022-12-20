<?php
declare(strict_types=1);

namespace Otus\Task07\Core\Config;

use Otus\Task07\Core\Config\Contracts\ConfigContract;


class Config implements ConfigContract, \ArrayAccess
{
    private array $container;

    public function __construct($path)
    {
        $this->container = require $path;
    }

    public function get($key) : mixed
    {
        return $this->container[$key] ?? null;
    }

    public function has(mixed $id): bool
    {
        return isset($this->container[$id]);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

}