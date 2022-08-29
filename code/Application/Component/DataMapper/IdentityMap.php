<?php

declare(strict_types=1);

namespace App\Application\Component\DataMapper;

use ArrayObject;
use OutOfBoundsException;
use SplObjectStorage;

class IdentityMap
{
    protected ArrayObject $idToObject;
    protected SplObjectStorage $objectToId;

    public function __construct()
    {
        $this->objectToId = new SplObjectStorage();
        $this->idToObject = new ArrayObject();
    }

    public function set(int $id, object $object): void
    {
        $this->idToObject[$id] = $object;
        $this->objectToId[$object] = $id;
    }

    public function getId(object $object): int
    {
        if (false === $this->hasObject($object)) {
            throw new OutOfBoundsException();
        }

        return $this->objectToId[$object];
    }

    public function hasId(int $id): bool
    {
        return isset($this->idToObject[$id]);
    }

    public function hasObject(object $object): bool
    {
        return isset($this->objectToId[$object]);
    }

    public function getObject(int $id): object
    {
        if (false === $this->hasId($id)) {
            throw new OutOfBoundsException();
        }

        return $this->idToObject[$id];
    }
}