<?php

namespace Otus\Task13\Core\ORM;

use Otus\Task13\Core\ORM\Contract\CollectionInterface;
use Otus\Task13\Core\ORM\Contract\EntityContract;
use Otus\Task13\Core\ORM\Contract\EntityManagerContract;
use PDO;

class Repository
{

    private Database $connection;
    private EntityMetaDataClass $metaDataClass;

    public function __construct(private readonly EntityManagerContract $entityManager, private readonly string $entityClass)
    {
        $this->metaDataClass = $this->entityManager->getMetaDataClass($this->entityClass);
        $this->connection = $this->entityManager->getConnection();
    }

    public function all(): Collection
    {
        $sql = "SELECT * FROM {$this->metaDataClass->getTable()};";
        $items = (array)$this->connection->statement($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $this->makeCollection($this->hydrate($items));
    }

    private function makeCollection(array $items): CollectionInterface
    {
        return new Collection($items);
    }

    private function hydrate(array $items = []): array
    {

        $class = $this->metaDataClass->getTransformClass();

        $result = [];
        foreach ($items as $item) {
            if (class_exists($class)) {
                $transformObject = new $class;
                $result[] = $this->entityManager->getIdentityMap()->append($transformObject->transform($item));
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }

    public function find($id): ?EntityContract
    {

        $pk = $this->metaDataClass->getPrimaryKey();

        if ($this->entityManager->getIdentityMap()->has($this->entityClass, $id)) {
            return $this->entityManager->getIdentityMap()->get($this->entityClass, $id);
        }

        $sql = "SELECT * FROM {$this->metaDataClass->getTable()} WHERE {$pk} = :{$pk}";
        $items = (array)$this->connection->statement($sql, [$pk => $id])->fetchAll(PDO::FETCH_ASSOC);
        $entity = $this->makeCollection($this->hydrate($items))->current();

        return $this->entityManager->getIdentityMap()->append($entity);
    }

}