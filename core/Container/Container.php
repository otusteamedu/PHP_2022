<?php


namespace Otus\Task07\Core\Container;


use Otus\Task07\Core\Container\Contracts\ContainerContract;

class Container implements ContainerContract, \ArrayAccess
{
    private array $containers = [];

    public function get(mixed $id){
        return isset($this->containers[$id]) ? $this->containers[$id] : null;
    }

    public function getContainer(mixed $id){
        return isset($this->containers[$id]) ? $this->containers[$id] : null;
    }

    public function set(mixed $id, mixed $value)
    {
        $this->containers[$id] = $value;
    }

    public function has(mixed $id): bool
    {
        return isset($this->containers[$id]);
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
        unset($this->containers[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }
}