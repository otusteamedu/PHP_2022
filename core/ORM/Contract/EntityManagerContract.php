<?php

namespace Otus\Task13\Core\ORM\Contract;


use Otus\Task13\Core\ORM\Repository;

interface EntityManagerContract
{
    public function getMetaDataClass(string|object $entityClass);

    public function getConnection();

    public function getIdentityMap(): EntityIdentityMapContract;

    public function create(EntityContract $entity): EntityContract;

    public function getRepository($entity): Repository;
}