<?php

namespace Otus\Task12\Core\ORM\Contract;


interface EntityManagerContract
{
    public function getMetaDataClass(string|object $entityClass);

    public function getConnection();

    public function getIdentityMap(): EntityIdentityMapContract;
}