<?php

namespace Otus\Task13\Core\Container;

use ArrayAccess;
use Otus\Task13\Core\Container\Contracts\ContainerContract;
use Otus\Task13\Core\Http\Request;

class Container implements ContainerContract, ArrayAccess
{
    private static ?ContainerContract $instance = null;
    private array $containers = [];

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getContainer(mixed $id)
    {
        return $this->containers[$id] ?? null;
    }

    public function getRequest(): Request
    {
        return $this->get('request');
    }

    public function get(mixed $id)
    {
        return $this->containers[$id] ?? null;
    }

    public function setRequest(Request $request)
    {
        $this->set('request', $request);
    }

    public function set(mixed $id, mixed $value)
    {
        $this->containers[$id] = $value;
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
}