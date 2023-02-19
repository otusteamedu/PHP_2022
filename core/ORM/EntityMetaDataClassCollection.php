<?php

namespace Otus\Task13\Core\ORM;


class EntityMetaDataClassCollection
{
    protected static $instance;

    final protected function __construct()
    {
    }

    final public static function instance()
    {
        return static::$instance ?? static::$instance = new static;
    }

    public function getMetadata($entityClass): EntityMetaDataClass
    {

        return new EntityMetaDataClass($entityClass);

    }
}