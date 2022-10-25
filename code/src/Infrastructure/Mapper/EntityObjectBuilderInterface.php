<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Mapper;

use Nikolai\Php\Domain\Entity\AbstractEntity;

interface EntityObjectBuilderInterface
{
    public function createObject(string $entityClass, array $entityValues): ?AbstractEntity;
}