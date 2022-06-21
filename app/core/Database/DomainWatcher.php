<?php

namespace Otus\Core\Database;

use Otus\Core\Database\Exception\DomainWatchException;

class DomainWatcher
{
    private array $all = [];
    private static self $instance;

    private function __construct()
    {
    }

    public static function add(Domainobject $obj): void
    {
        $inst = self::instance();
        $inst->all[$inst->globalKey($obj)] = $obj;
    }

    public static function deleteByClassAndId(string $classname, $id): void
    {
        $inst = self::instance();
        $key = $inst->makeKey($classname, $id);
        if (isset($inst->all[$key])) {
            unset($inst->all[$key]);
        }
    }

    public static function getByClassAndId(string $classname, $id): DomainObject
    {
        $inst = self::instance();
        $key = $inst->makeKey($classname, $id);
        if (isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        throw new DomainWatchException("Key by class: $classname and id: $id does not exists");
    }

    private function globalKey(DomainObject $obj): string
    {
        return $this->makeKey(get_class($obj), $obj->getId());
    }

    private function makeKey(string $classname, $key): string
    {
        return $classname . "." . $key;
    }

    private static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new DomainWatcher();
        }
        return self::$instance;
    }

    private function __clone()
    {

    }
}