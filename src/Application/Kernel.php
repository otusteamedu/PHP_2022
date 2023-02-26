<?php

declare(strict_types=1);

namespace Src\Application;

use DI\{DependencyException, NotFoundException};
use Src\Application\Contracts\Infrastructure\Routes\RouterGateway;
use Src\Application\Contracts\Infrastructure\Queues\QueueConsumerGateway;

final class Kernel
{
    /**
     * @return void
     * @throws \Exception
     */
    public function runHttpApplication(): void
    {
        \app()->initializeDependencies();

        $this->captureRequest();
    }

    /**
     * @return void
     * @throws DependencyException
     * @throws NotFoundException
     * @throws \Exception
     */
    public function runAmqpConsumer(): void
    {
        \app()->initializeDependencies();

        $consumer = \app()->make(dependency: QueueConsumerGateway::class);

        $consumer->consume();
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
