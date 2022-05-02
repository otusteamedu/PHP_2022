<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\classes;

use Mselyatin\Project6\src\interfaces\ApplicationInterface;
use Mselyatin\Project6\src\interfaces\ResponseInterface;
use Mselyatin\Project6\src\interfaces\RouteManagerInterface;

/**
 * @Application
 * @\Application
 * @author Михаил Селятин
 */
class Application implements ApplicationInterface
{
    /** @var ?Application  */
    public static ?Application $app = null;

    /** @var array  */
    private array $config;

    /** @var RouteManagerInterface  */
    private RouteManagerInterface $routeManager;

    private function __construct(
        array $config,
        RouteManagerInterface $routeManager
    ) {
        $this->config = $config;
        $this->routeManager = $routeManager;
    }

    /**
     * @param array $config
     * @param RouteManagerInterface $routeManager
     * @return ApplicationInterface
     */
    public static function create(
        array $config,
        RouteManagerInterface $routeManager
    ): ApplicationInterface {
        if (null === static::$app) {
            static::$app = new static(
                $config,
                $routeManager
            );
        }

        return static::$app;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $this->loadRoute();
        } catch (\Throwable $e) {
            exit('Error config');
        }
    }

    /**
     * @return void
     */
    private function loadRoute(): void
    {
        $this->routeManager->init();
        $this->routeManager->mapping();
    }
}