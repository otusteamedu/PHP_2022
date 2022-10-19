<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Service;

use Nikolai\Php\Domain\Mapper\MapperInterface;

class ServiceManager
{
    private static MapperInterface $mapper;

    public static function getMapper(): MapperInterface
    {
        return self::$mapper;
    }

    public static function setMapper(MapperInterface $mapper): void
    {
        self::$mapper = $mapper;
    }
}