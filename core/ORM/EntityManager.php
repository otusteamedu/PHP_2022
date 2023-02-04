<?php

namespace Otus\Task12\Core\ORM;

use Otus\Task12\Core\Container\Container;
use Otus\Task12\Core\ORM\Contract\EntityContract;
use Otus\Task12\Core\ORM\Contract\EntityManagerContract;
use Otus\Task12\Core\ORM\Contract\EntityIdentityMapContract;

class EntityManager implements EntityManagerContract
{
    private Databases $connection;
    private EntityIdentityMapContract $identityMap;

    public function __construct()
    {
        $this->connection = Container::instance()->get('database');
        $this->identityMap = EntityIdentityMap::instance();
    }

    public function getConnection(): Databases
    {
        return $this->connection;
    }

    public function create(EntityContract $entity): EntityContract
    {
        $metadata = $this->getMetaDataClass($entity);

        $columns = implode(', ', $metadata->getColums());
        $values = implode(', ',array_map(static fn($column) => ':' . $column, $metadata->getColums()));

        $sql = "INSERT INTO {$metadata->getTable()} ($columns) VALUES ($values)";

        $binding = [];
        foreach($metadata->getColums() as $property => $column){
            $binding[$column] = $entity->{'get' . ucfirst($property)}();
        }

        $this->connection->statement($sql, $binding);
        $entity = $this->getRepository($entity)->find($this->connection->lastInsertId());

        return $this->identityMap->append($entity);
    }

    public function update(EntityContract $entity): EntityContract
    {
        $metadata = $this->getMetaDataClass($entity);

        $pk = $metadata->getPrimaryKey();
        $columns = implode(', ',array_map(static fn($column) => $column .' = :' . $column, $metadata->getColums()));
        $sql = "UPDATE {$metadata->getTable()} SET $columns WHERE {$pk} = :{$pk} ";

        $binding = [];
        foreach($metadata->getColums() as $property => $column) {
            $binding[$column] = $entity->{'get' . ucfirst($property)}();
        }
        $this->connection->statement($sql, $binding);

        return $this->identityMap->append($entity);
    }

    public function delete(EntityContract $entity): void
    {
        $metadata = $this->getMetaDataClass($entity);

        $pk = $metadata->getPrimaryKey();
        $sql = "DELETE FROM {$metadata->getTable()}  WHERE {$pk} = :{$pk}";
        $this->connection->statement($sql, [$pk => $entity->{'get' . ucfirst($pk)}()]);
    }

    public function getMetaDataClass($entityClass): EntityMetaDataClass
    {
       $entityClass = is_object($entityClass) ? get_class($entityClass) : $entityClass;
       return EntityMetaDataClassCollection::instance()->getMetadata($entityClass);
    }

    public function getRepository($entity): Repository
    {
        $entity = is_object($entity) ? get_class($entity) : $entity;
        return new Repository($this, $entity);
    }

    public function getIdentityMap(): EntityIdentityMapContract
    {
        return $this->identityMap;
    }
}