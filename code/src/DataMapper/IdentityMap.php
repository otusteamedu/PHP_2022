<?php


namespace Study\Cinema\DataMapper;

use ArrayObject;
use SplObjectStorage;
use OutOfBoundsException;

final class IdentityMap
{

    private array $map;

    public function __construct()
    {
        $this->map = [];
    }

    public function set(object $object, int $id): void
    {
       $this->map[get_class($object).':'.$id] = $object;
    }

    public function get(string $className, int $id): ?object
    {
        return $this->map[$className.':'.$id] ?? null;
    }

    public function exists(string $className, int $id): bool
    {
        return isset($this->map[$className.':'.$id]);
    }

    public function remove(object $object, int $id): void
    {
         $this->map[get_class($object).':'.$id] = null;
    }

}
