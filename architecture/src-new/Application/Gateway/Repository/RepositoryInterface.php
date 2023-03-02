<?php

declare(strict_types=1);

namespace App\Application\Gateway\Repository;

interface RepositoryInterface
{
    public function save(object $object): void;

    public function delete(string $id): void;

    /**
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * @return object[]
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);
}