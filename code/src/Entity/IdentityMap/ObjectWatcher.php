<?php

namespace Ppro\Hw15\Entity\IdentityMap;
class ObjectWatcher
{
    /**
     * @var
     */
    private static $_instance;

    /**
     * @var array
     */
    private $objects = array();

    /**
     * @return ObjectWatcher
     */
    static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new ObjectWatcher;
        }
        return self::$_instance;
    }

    /**
     * @param $className
     * @param $id
     * @return mixed|null
     */
    static function getRecord($className, $id)
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
     * @param $id
     * @return void
     */
    static function addRecord($obj, $id)
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($obj, $id)] = $obj;
    }

    /**
     * @param $obj
     * @param $id
     * @return string
     */
    function getKey($obj, $id)
    {
        return get_class($obj) . '.' . $id;
    }

}