<?php
namespace Otus\Task11\Core\Container;

use Otus\Task11\Core\Container\Contracts\ContainerContract;
use Otus\Task11\Core\Http\Request;

class Container implements ContainerContract, \ArrayAccess
{
    private static ?ContainerContract $instance = null;
    private array $containers = [];

    private function __construct(){}

    public static function instance(): self
    {
        if (is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get(mixed $id){
        return $this->containers[$id] ?? null;
    }

    public function getContainer(mixed $id){
        return $this->containers[$id] ?? null;
    }

    public function set(mixed $id, mixed $value)
    {
        $this->containers[$id] = $value;
    }

    public function getRequest(): Request
    {
       return $this->get('request');
    }

    public function setRequest(Request $request)
    {
        $this->set('request', $request);
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