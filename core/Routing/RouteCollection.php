<?php

namespace Otus\Task12\Core\Routing;

use Traversable;

class RouteCollection implements \ArrayAccess, \IteratorAggregate
{
    private array $container = [];
    public function add(Route $route){
        $this->container[] = $route;
    }

    public function offsetSet(mixed $offset, mixed $value): void{
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->container[$offset]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->container[$offset] ?? null;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->container);
    }
}