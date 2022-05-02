<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\interfaces;

/**
 * @ApplicationInterface
 * @\ApplicationInterface
 */
interface ApplicationInterface
{
    public static function create(
        array $config,
        RouteManagerInterface $routeManager
    ): ApplicationInterface;

    public function run();
}