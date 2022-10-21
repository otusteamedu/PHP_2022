<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Nikolai\Php\Domain\Entity\AbstractEntity;

class EntityObjectBuilder implements EntityObjectBuilderInterface
{
    public function createObject(string $entityClass, array $entityValues): ?AbstractEntity
    {
        if (!$entityValues) {
            return null;
        }

        return new $entityClass(...$entityValues);
    }
}