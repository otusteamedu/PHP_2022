<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use ArrayObject;
use SplObjectStorage;
use OutOfBoundsException;

final class IdentityMap
{
    /**
     * @var ArrayObject
     */
    protected ArrayObject $id_to_object;

    /**
     * @var SplObjectStorage
     */
    protected SplObjectStorage $object_to_id;

    public function __construct()
    {
        $this->object_to_id = new SplObjectStorage();
        $this->id_to_object = new ArrayObject();
    }

    /**
     * @param int $id
     * @param mixed $object
     * @return void
     */
    public function set(mixed $object, int $id): void
    {
        $this->id_to_object[$id]     = $object;
        $this->object_to_id[$object] = $id;
    }

    /**
     * @param mixed $object
     * @throws OutOfBoundsException
     * @return integer
     */
    public function getId(mixed $object): int
    {
        if (false === $this->hasObject($object)) {
            throw new OutOfBoundsException();
        }

        return $this->object_to_id[$object];
    }

    /**
     * @param integer $id
     * @return boolean
     */
    public function hasId(int $id): bool
    {
        return isset($this->id_to_object[$id]);
    }

    /**
     * @param mixed $object
     * @return boolean
     */
    public function hasObject(mixed $object): bool
    {
        return isset($this->object_to_id[$object]);
    }

    /**
     * @param integer $id
     * @throws OutOfBoundsException
     * @return object
     */
    public function getObject(int $id): object
    {
        if (false === $this->hasId($id)) {
            throw new OutOfBoundsException();
        }

        return $this->id_to_object[$id];
    }
}
