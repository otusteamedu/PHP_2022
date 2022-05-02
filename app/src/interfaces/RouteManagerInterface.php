<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\interfaces;

/**
 * @RouteManagerInterface
 * @\Mselyatin\Project6\src\interfaces\RouteManagerInterface
 */
interface RouteManagerInterface
{
    public function init(): void;
    public function mapping(): void;
}