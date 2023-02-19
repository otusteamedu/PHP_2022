<?php
declare(strict_types=1);

namespace Otus\Task13\Core\Config;

use ArrayAccess;
use Otus\Task13\Core\Config\Contracts\ConfigInterface;


class Config implements ConfigInterface, ArrayAccess
{
    private array $container;

    public function __construct($path)
    {

        $this->container = require $path;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function has(mixed $id): bool
    {
        return isset($this->containers[$id]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->containers[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function get($key): mixed
    {
        return $this->container[$key] ?? null;
    }

}