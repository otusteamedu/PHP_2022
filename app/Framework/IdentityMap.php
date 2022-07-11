<?php

namespace App\Framework;

use App\Models\HasIdInterface;

class IdentityMap
{
    private array $items = [];


    public function getById(string $class, int $id): ?HasIdInterface
    {
        $this->items[$class] ??= [];

        if ($this->hasId($class, $id)) {
            return $this->items[$class][$id];
        }

        throw new \OutOfBoundsException('Item not found');
    }


    public function hasId(string $class, int $id): bool
    {
        $this->items[$class] ??= [];

        return array_key_exists($id, $this->items[$class]);
    }


    public function set(HasIdInterface $object)
    {
        $this->items[get_class($object)] ??= [];

        $this->items[get_class($object)][$this->getId($object)] = $object;
    }


    public function remove(HasIdInterface $object)
    {
        $this->items[get_class($object)] ??= [];

        unset($this->items[get_class($object)][$this->getId($object)]);
    }


    private function getId(HasIdInterface $object): string
    {
        return $object->getId();
    }
}
