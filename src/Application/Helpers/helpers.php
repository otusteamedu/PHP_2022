<?php

declare(strict_types=1);

use Src\Application\Bootstrap\DependencyContainer;

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @return DependencyContainer
     */
    function app(): DependencyContainer
    {
        return DependencyContainer::getInstance();
    }
}
