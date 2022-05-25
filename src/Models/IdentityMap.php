<?php

namespace Qween\Php2022\Models;

class IdentityMap
{

    /**
     * @var IdentityMap
     */
    private static IdentityMap $_instance;

    /**
     * @var array
     */
    private array $objects = [];

    /**
     * @return IdentityMap
     */
    static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new IdentityMap;
        }
        return self::$_instance;
    }

    /**
     * @param string $className
     * @param int $id
     *
     * @return mixed null or object of the class $className with an id = $id if it exists.
     */
    static function getRecord(string $className, int $id): mixed
    {
        $inst = self::getInstance();
        $key = "$className.$id";
        if (isset($inst->objects[$key])) {
            return $inst->objects[$key];
        }
        return null;
    }

    /**
     * @param $obj
     * @param int $id
     */
    static function addRecord($obj, int $id): void
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($obj, $id)] = $obj;
    }

    function getKey($obj, $id)
    {
        return get_class($obj) . '.' . $id;
    }
}
