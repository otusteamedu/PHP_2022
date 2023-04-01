<?php

namespace Otus\Task14\Core\ORM;


use Otus\Task14\Core\ORM\Contract\EntityContract;
use Otus\Task14\Core\ORM\Contract\EntityIdentityMapContract;

class EntityIdentityMap implements EntityIdentityMapContract
{
    private static $instance;
    private array $objects = [];

    final protected function __construct()
    {
    }

    final public static function instance(): self
    {
        return static::$instance ?? static::$instance = new static;
    }

    public function append(EntityContract $entity): EntityContract
    {
        if (method_exists($entity, 'getId')) {
            $this->objects[$this->getObjectId($entity, $entity->getId())] = $entity;
        }
        return $entity;
    }

    private function getObjectId(mixed $entity, string $id): string
    {
        $class = is_object($entity) ? get_class($entity) : $entity;
        return $class . '@' . $id;
    }

    public function get(mixed $entity, string $id): EntityContract
    {

        if ($this->has($entity, $id)) {
            return $this->objects[$this->getObjectId($entity, $id)];
        }

        return $entity;
    }

    public function has(mixed $entity, string $id): bool
    {
        return array_key_exists($this->getObjectId($entity, $id), $this->objects);
    }


}