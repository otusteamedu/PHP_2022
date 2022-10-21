<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Collection;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;
use Nikolai\Php\Domain\Service\ServiceManager;

class LazyLoadCollection extends AbstractLazyCollection
{
    public function __construct(private AbstractEntity $entity, private string $propertyName) {}

    protected function doInitialize()
    {
        $this->collection = ServiceManager::getMapper()->getCollection(
            $this->entity,
            $this->propertyName
        );
    }
}