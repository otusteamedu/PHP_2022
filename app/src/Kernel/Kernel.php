<?php

declare(strict_types=1);

namespace App\Src\Kernel;

use App\Src\Infrastructure\Http\Router;
use App\Src\Kernel\Configuration\Configurator;
use App\Src\Repositories\Contracts\Repository;

final class Kernel
{
    private Router $router;
    private Configurator $configurator;

    /**
     * Kernel class constructor
     */
    public function __construct()
    {
        $this->router = new Router();
        $this->configurator = Configurator::getInstance();
    }

    /**
     * @return void
     */
    public function initializeApiApplication(): void
    {
        $this->configurator->createConfig();
        $this->router->captureRequest();
    }

    /**
     * @return void
     */
    public function initializeCliApplication(): void
    {
        $this->configurator->createConfig();
    }

    /**
     * @return Repository
     */
    public function repository(): Repository
    {
        return $this->configurator->getRepository();
    }
}
