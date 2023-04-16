<?php

namespace Otus\Task14\Core\ORM;

use Otus\Task14\Core\ORM\Mapping\Column;
use Otus\Task14\Core\ORM\Mapping\Entity;
use Otus\Task14\Core\ORM\Mapping\PrimaryKey;
use Otus\Task14\Core\ORM\Mapping\Table;
use ReflectionClass;

class EntityMetaDataClass
{

    private string $table;
    private string $primaryKey;
    private array $columns = [];
    private string $transformClass;

    public function __construct(string $entity)
    {
        $class = new ReflectionClass($entity);
        $attributes = $class->getAttributes();

        foreach ($attributes as $attribute) {
            $object = $attribute->newInstance();
            if ($object instanceof Table) {
                $this->table = $object->name;
            }
            if ($object instanceof Entity) {
                $this->transformClass = $object->transform;
            }
        }

        foreach ($class->getProperties() as $property) {
            $propertyName = $property->getName();

            foreach ($property->getAttributes(Column::class) as $attribute) {
                $object = $attribute->newInstance();
                $this->columns[$propertyName] = $object->name;
            }

            foreach ($property->getAttributes(PrimaryKey::class) as $attribute) {
                $object = $attribute->newInstance();
                $this->columns[$propertyName] = $object->primaryKey;
                $this->primaryKey = $object->primaryKey;
            }
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    public function getTransformClass(): string
    {
        return $this->transformClass;
    }

    public function getColums(): array
    {
        return $this->columns;
    }
}