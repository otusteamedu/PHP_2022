<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Doctrine\Common\Collections\ArrayCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;
use Nikolai\Php\Domain\Mapper\MapperInterface;
use Nikolai\Php\Infrastructure\Exception\MapperException;
use Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilderFactoryInterface;

class Mapper implements MapperInterface
{
    const FIELD_ID = 'id';

    public function __construct(
        private SqlBuilderFactoryInterface $sqlBuilderFactory,
        private MappingConfiguratorInterface $mappingConfigurator,
        private EntityObjectBuilderInterface $entityObjectBuilder
    ) {}

    public function insert(AbstractEntity $entity): AbstractEntity
    {
        if ($entity->getId()) {
            throw new MapperException('Запись уже сохранена! id: ' . $entity['id']);
        }

        $sqlBuilder = $this->sqlBuilderFactory->insert()
            ->table($this->mappingConfigurator->getTable($entity));

        $properties = $this->mappingConfigurator->getEntityProperties($entity);
        foreach ($properties as $property) {
            if ($this->mappingConfigurator->isFieldEntityId($property['fieldName']) ||
                $this->mappingConfigurator->isCollectionType($property['type'])) {
                continue;
            }
            elseif ($this->mappingConfigurator->isEntityType($property['type'])) {
                $referenceEntity = $this->getValue($entity, $property['name']);
                $idReferenceEntity = $referenceEntity->getId();

                /**
                 * У связанной сущности уже есть id, т.е. она уже сохранена,
                 * поэтому обновляем ее, иначе (нет id) - добавляем и ее
                 */
                if ($idReferenceEntity) {
//                    $this->update($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $idReferenceEntity);
                } else {
                    $insertedReferenceEntity = $this->insert($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $insertedReferenceEntity->getId());
                }
            }
            else {
                $value = $this->getValue($entity, $property['name']);
                $sqlBuilder->value($property['fieldName'], $value);
            }
        }

        $result = $sqlBuilder->execute();
        $entity->setId($result);

        return $entity;
    }

    public function update(AbstractEntity $entity): AbstractEntity
    {
        if (!$entity->getId()) {
            throw new MapperException('Запись еще не сохранена!');
        }

        $sqlBuilder = $this->sqlBuilderFactory->update()
            ->table($this->mappingConfigurator->getTable($entity));

        $properties = $this->mappingConfigurator->getEntityProperties($entity);
        foreach ($properties as $property) {
            if ($this->mappingConfigurator->isFieldEntityId($property['fieldName'])) {
                $sqlBuilder->where(self::FIELD_ID, $entity->getId());
            }
            elseif ($this->mappingConfigurator->isCollectionType($property['type'])) {
                continue;
            }
            elseif ($this->mappingConfigurator->isEntityType($property['type'])) {
                $referenceEntity = $this->getValue($entity, $property['name']);
                $idReferenceEntity = $referenceEntity->getId();

                if ($idReferenceEntity) {
                    $this->update($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $idReferenceEntity);
                } else {
                    $insertedReferenceEntity = $this->insert($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $insertedReferenceEntity->getId());
                }
            }
            else {
                $value = $this->getValue($entity, $property['name']);
                $sqlBuilder->value($property['fieldName'], $value);
            }
        }

        $sqlBuilder->execute();

        return $entity;
    }

    public function delete(AbstractEntity $entity): bool
    {
        if (!$entity->getId()) {
            throw new MapperException('Не возможно удалить еще не сохраненную запись!');
        }

        return $this->sqlBuilderFactory->delete()
            ->table($this->mappingConfigurator->getTable($entity))
            ->where(self::FIELD_ID, $entity->getId())
            ->execute();
    }

    public function find(string $entityClass, int $id): ?AbstractEntity
    {
        $this->mappingConfigurator->verifyEntity($entityClass);

        $result = $this->sqlBuilderFactory->select()
            ->table($this->mappingConfigurator->getTable($entityClass))
            ->where(self::FIELD_ID, $id)
            ->execute();

        if ($result) {
            $preparedResult = $this->prepareResult($entityClass, $result[0]);
            return $this->entityObjectBuilder->createObject(
                $entityClass,
                $preparedResult
            );
        }

        return null;
    }

    public function findBy(string $entityClass, array $params): ArrayCollection
    {
        $this->mappingConfigurator->verifyEntity($entityClass);

        $sqlBuilder = $this->sqlBuilderFactory->select()
            ->table($this->mappingConfigurator->getTable($entityClass));

        foreach ($params as $field => $value) {
            $sqlBuilder->where($field, $value);
        }

        $result = $sqlBuilder->execute();

        $elements = [];
        foreach ($result as $item) {
            $preparedResult = $this->prepareResult($entityClass, $item);
            $elements[] = $this->entityObjectBuilder->createObject(
                $entityClass,
                $preparedResult
            );
        }

        return new ArrayCollection($elements);
    }

    private function prepareResult(string $entityClass, array $result): array
    {
        $preparedResult = [];
        $properties = $this->mappingConfigurator->getEntityProperties($entityClass);

        foreach ($properties as $property) {
            if ($this->mappingConfigurator->isEntityType($property['type'])) {
                $preparedResult[$property['name']] = $this->find(
                    $property['type'],
                    $result[$property['fieldName']]
                );
            } elseif ($this->mappingConfigurator->isCollectionType($property['type'])) {
                continue;
            }
            else {
                $preparedResult[$property['name']] = $result[$property['fieldName']];
            }
        }

        return $preparedResult;
    }

    public function getCollection(AbstractEntity $entity, string $propertyName): ArrayCollection
    {
        $result = new ArrayCollection([]);
        $properties = $this->mappingConfigurator->getEntityProperties($entity);
        foreach ($properties as $property) {
            if ($property['name'] === $propertyName) {
                $filter[$property['fieldName']] = $entity->getId();
                $result = $this->findBy($property['itemCollectionClass'], $filter);
                break;
            }
        }

        return $result;
    }

    private function getValue(AbstractEntity $entity, string $propertyName)
    {
        $getterName = 'get' . ucfirst($propertyName);
        return $entity->$getterName();
    }
}