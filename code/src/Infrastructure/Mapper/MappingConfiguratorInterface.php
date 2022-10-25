<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Nikolai\Php\Domain\Entity\AbstractEntity;

interface MappingConfiguratorInterface
{
    public function getTable(AbstractEntity|string $entityOrEntityClass): string;
    public function getShortNameClass(AbstractEntity|string $entityOrEntityClass): string;
    public function getEntityProperties(AbstractEntity|string $entityOrEntityClass): array;
    public function isEntityType(string $type): bool;
    public function isCollectionType(string $type): bool;
    public function isFieldEntityId(string $fieldName): bool;
    public function verifyEntity(string $entityClass): void;
}