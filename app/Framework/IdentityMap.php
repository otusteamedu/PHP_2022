<?php

namespace App\Framework;

use App\Models\HasIdInterface;

class IdentityMap
{
    private array $items = [];


    public function getById(string $class, int $id)
    {
        $this->items[$class] ??= [];

        if ($this->hasId($class, $id)) {
            return $this->items[$class][$id];
        }

        return null;
    }


    public function has(HasIdInterface $object): bool
    {
        $this->items[get_class($object)] ??= [];

        return array_key_exists($this->getId($object), $this->items[get_class($object)]);
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
