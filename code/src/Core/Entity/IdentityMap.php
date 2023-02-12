<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Core\Entity;

class IdentityMap
{
    protected array $all = [];
    protected static ?IdentityMap $instance = null;

    public static function getInstance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new IdentityMap();
        }

        return self::$instance;
    }

    public function globalKey(Entity $obj): string
    {
        return get_class($obj) . '.' . $obj->getId();
    }

    public static function add(Entity $obj): void
    {
        $inst = self::getInstance();
        $inst->all[$inst->globalKey($obj)] = $obj;
    }

    public static function exist(string $classname, int $id): ?Entity
    {
        $inst = self::getInstance();
        $key = "{$classname} . {$id}";

        if (isset($inst->all[$key])) {
            return $inst->all[$key];
        }

        return null;
    }

    public static function getAll(string $className = null): array
    {
        $inst = self::getInstance();

        if ($className) {
            array_walk($inst->all, function ($element, $key) use ($className, &$all) {
                if (str_contains($key, $className)) {
                    $all[$key] = $element;
                }
            });
        }

        return $all ?? $inst->all;
    }
}