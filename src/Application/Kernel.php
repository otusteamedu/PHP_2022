<?php

declare(strict_types=1);

namespace Src\Application;

use DI\{DependencyException, NotFoundException};
use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;

final class Kernel
{
    /**
     * @return void
     * @throws \Exception
     */
    public function runApplication(): void
    {
        \app()->initializeDependencies();

        $this->captureRequest();
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function captureRequest(): void
    {
        $route = \app()->make(dependency: RouterGateway::class);

        $route->captureRequests();
    }
}
