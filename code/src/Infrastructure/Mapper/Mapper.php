<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Doctrine\Common\Collections\ArrayCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;
use Nikolai\Php\Domain\Collection\LazyLoadCollection;
use Nikolai\Php\Domain\Mapper\MapperInterface;
use Nikolai\Php\Infrastructure\Exception\MapperException;
use Nikolai\Php\Infrastructure\SqlBuilder\SqlBuilder;
use ReflectionClass;

class Mapper implements MapperInterface
{
    const FIELD_ID = 'id';
    const SCALAR_TYPES = ['int', 'string'];

    private array $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function insert(AbstractEntity $entity): AbstractEntity
    {
        $entityShortClass = $this->getShortClassName($entity);
        $sqlBuilder = SqlBuilder::insert()
            ->table($this->mapping[$entityShortClass]['tableName']);

        foreach ($this->mapping[$entityShortClass]['properties'] as $property) {
            if ($this->isFieldEntityId($property['fieldName'])) {
                continue;
            }
            elseif ($this->isCollectionType($property['type'])) {
                continue;
            }
            elseif ($this->isScalarType($property['type'])) {
                $value = $this->getValue($entity, $property['name']);
                $sqlBuilder->value($property['fieldName'], $value);
            }
            elseif ($this->isEntityType($property['type'])) {
                $referenceEntity = $this->getValue($entity, $property['name']);
                $idReferenceEntity = $referenceEntity->getId();

                /**
                 * У связанной сущности уже есть id, т.е. она уже сохранена,
                 * поэтому обновляем ее, иначе (нет id) - добавляем и ее
                 */
                if ($idReferenceEntity) {
                    $this->update($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $idReferenceEntity);
                } else {
                    $insertedReferenceEntity = $this->insert($referenceEntity);
                    $sqlBuilder->value($property['fieldName'], $insertedReferenceEntity->getId());
                }
            }
        }

        $result = $sqlBuilder->execute();
        $entity->setId($result);

        return $entity;
    }

    public function update(AbstractEntity $entity): AbstractEntity
    {
        $entityShortClass = $this->getShortClassName($entity);
        $sqlBuilder = SqlBuilder::update()
            ->table($this->mapping[$entityShortClass]['tableName']);

        foreach ($this->mapping[$entityShortClass]['properties'] as $property) {
            if ($this->isFieldEntityId($property['fieldName'])) {
                $sqlBuilder->where(self::FIELD_ID, $entity->getId());
            }
            elseif ($this->isCollectionType($property['type'])) {
                continue;
            }
            elseif ($this->isScalarType($property['type'])) {
                $value = $this->getValue($entity, $property['name']);
                $sqlBuilder->value($property['fieldName'], $value);
            }
            elseif ($this->isEntityType($property['type'])) {
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
        }

        $sqlBuilder->execute();

        return $entity;
    }

    public function delete(AbstractEntity $entity): bool
    {
        $result = false;
        $entityShortClass = $this->getShortClassName($entity);

        if ($entity->getId()) {
            $result = SqlBuilder::delete()
                ->table($this->mapping[$entityShortClass]['tableName'])
                ->where(self::FIELD_ID, $entity->getId())
                ->execute();
        }

        return $result;
    }

    public function find(string $entityClass, int $id): ?AbstractEntity
    {
        $this->verifyEntity($entityClass);
        $entityShortClass = $this->getShortClassName($entityClass);

        $result = SqlBuilder::select()
            ->table($this->mapping[$entityShortClass]['tableName'])
            ->where(self::FIELD_ID, $id)
            ->execute();

        if ($result) {
            return $this->createObject(
                $entityClass,
                $this->mapping[$entityShortClass]['properties'],
                $result[0]
            );
        }

        return null;
    }

    public function findBy(string $entityClass, array $params): ArrayCollection
    {
        $this->verifyEntity($entityClass);
        $entityShortClass = $this->getShortClassName($entityClass);

        $sqlBuilder = SqlBuilder::select()
            ->table($this->mapping[$entityShortClass]['tableName']);

        foreach ($params as $field => $value) {
            $sqlBuilder->where($field, $value);
        }

        $result = $sqlBuilder->execute();

        $elements = [];
        foreach ($result as $item) {
            $elements[] = $this->createObject(
                $entityClass,
                $this->mapping[$entityShortClass]['properties'],
                $item
            );
        }

        return new ArrayCollection($elements);
    }

    public function createObject(string $entityClass, array $entityProperties, array $resultFromDb): ?AbstractEntity
    {
        if (!$resultFromDb) {
            return null;
        }

        $values = [];
        foreach ($entityProperties as $property) {
            if ($this->isScalarType($property['type'])) {
                $values[] = $resultFromDb[$property['fieldName']];
            } elseif ($this->isEntityType($property['type'])) {
                $values[] = $this->find($property['type'], $resultFromDb[$property['fieldName']]);
            }
        }

        return new $entityClass(...$values);
    }

    public function getMapping(): array
    {
        return $this->mapping;
    }

    public function getShortClassName(AbstractEntity|string $entity): string
    {
        try {
            return (new ReflectionClass($entity))->getShortName();
        } catch (\Exception $exception) {
            throw new MapperException('Не возможно определить короткое имя класса: ' . $entity);
        }
    }

    private function getValue(AbstractEntity $entity, string $propertyName)
    {
        $getterName = 'get' . ucfirst($propertyName);
        return $entity->$getterName();
    }

    private function verifyEntity(string $entityClass): void
    {
        if((new ReflectionClass($entityClass))->getParentClass()->getName() !== AbstractEntity::class) {
            throw new MapperException('Класс: ' . $entityClass . ' не является наследником класса ' . AbstractEntity::class);
        }
    }

    private function isScalarType(string $type): bool
    {
        return in_array($type, self::SCALAR_TYPES);
    }

    private function isEntityType(string $type): bool
    {
        try {
            if ((new ReflectionClass($type))->getParentClass()->getName() === AbstractEntity::class) {
                return true;
            }
        } catch (\Exception $exception) {}

        return false;
    }

    private function isCollectionType(string $type): bool
    {
        return $type === LazyLoadCollection::class;
    }

    private function isFieldEntityId(string $fieldName): bool
    {
        return $fieldName === self::FIELD_ID;
    }
}