<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Nikolai\Php\Domain\Entity\AbstractEntity;
use Nikolai\Php\Domain\Service\ServiceManager;

class LazyLoadCollection extends AbstractLazyCollection
{
    public function __construct(private AbstractEntity $entity, private string $propertyName) {}

    protected function doInitialize()
    {
        $filter = [];
        $result = new ArrayCollection([]);

        $mapper = ServiceManager::getMapper();

        $entityShortClass = $mapper->getShortClassName($this->entity);
        $entityMapping = $mapper->getMapping()[$entityShortClass];

        foreach ($entityMapping['properties'] as $property) {
            if ($property['name'] === $this->propertyName) {
                $filter[$property['fieldName']] = $this->entity->getId();
                $itemCollectionClass = $property['itemCollectionClass'];
                $result = $mapper->findBy($itemCollectionClass, $filter);
                break;
            }
        }

        $this->collection = $result;
    }
}