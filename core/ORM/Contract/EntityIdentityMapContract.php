<?php

namespace Otus\Task14\Core\ORM\Contract;

interface EntityIdentityMapContract
{
    public function append(EntityContract $entity);

    public function has($entity, string $id);

    public function get($entity, string $id);
}