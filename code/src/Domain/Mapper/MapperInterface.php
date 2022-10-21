<?php

namespace Nikolai\Php\Domain\Mapper;

use Doctrine\Common\Collections\ArrayCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;

interface MapperInterface
{
    public function insert(AbstractEntity $entity): AbstractEntity;
    public function update(AbstractEntity $entity): AbstractEntity;
    public function delete(AbstractEntity $entity): bool;
    public function find(string $entityClass, int $id): ?AbstractEntity;
    public function findBy(string $entityClass, array $params): ArrayCollection;
    public function getCollection(AbstractEntity $entity, string $propertyName): ArrayCollection;
}
