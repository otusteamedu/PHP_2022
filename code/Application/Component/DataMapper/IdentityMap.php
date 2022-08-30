<?php

declare(strict_types=1);

namespace App\Application\Component\DataMapper;

use ArrayObject;

class IdentityMap
{
    protected ArrayObject $idToObject;

    public function __construct()
    {
        $this->idToObject = new ArrayObject();
    }

    public function set(int $id, object $object): void
    {
        $this->idToObject[$id] = $object;
    }

    public function hasId(int $id): bool
    {
        return isset($this->idToObject[$id]);
    }
}