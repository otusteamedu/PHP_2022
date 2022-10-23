<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Nikolai\Php\Domain\Collection\LazyLoadCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;
use Nikolai\Php\Infrastructure\Exception\MapperException;

class MappingConfigurator implements MappingConfiguratorInterface
{
    const FIELD_ID = 'id';

    public function __construct(private array $mapping) {}

    public function getTable(string|AbstractEntity $entityOrEntityClass): string
    {
        $entityShortNameClass = $this->getShortNameClass($entityOrEntityClass);
        return $this->mapping[$entityShortNameClass]['tableName'];
    }

    public function getShortNameClass(string|AbstractEntity $entityOrEntityClass): string
    {
        try {
            return (new \ReflectionClass($entityOrEntityClass))->getShortName();
        } catch (\Exception $exception) {
            throw new MapperException('Не возможно определить короткое имя класса: ' . $entityOrEntityClass);
        }
    }

    public function getEntityProperties(string|AbstractEntity $entityOrEntityClass): array
    {
        $entityShortNameClass = $this->getShortNameClass($entityOrEntityClass);
        return $this->mapping[$entityShortNameClass]['properties'];
    }

    public function isEntityType(string $type): bool
    {
        try {
            if ((new \ReflectionClass($type))->getParentClass()->getName() === AbstractEntity::class) {
                return true;
            }
        } catch (\Exception $exception) {}

        return false;
    }

    public function isCollectionType(string $type): bool
    {
        return $type === LazyLoadCollection::class;
    }

    public function isFieldEntityId(string $fieldName): bool
    {
        return $fieldName === self::FIELD_ID;
    }

    public function verifyEntity(string $entityClass): void
    {
        if((new \ReflectionClass($entityClass))->getParentClass()->getName() !== AbstractEntity::class) {
            throw new MapperException('Класс: ' . $entityClass . ' не является наследником класса ' . AbstractEntity::class);
        }
    }
}