<?php

declare(strict_types=1);

namespace Mselyatin\Project6\src\classes;

use Mselyatin\Project6\src\interfaces\ApplicationInterface;
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

    /** @var string  */
    private string $defaultRouteManager = RouteManager::class;

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $config
     * @return ApplicationInterface
     */
    public static function create(array $config): ApplicationInterface
    {
        if (null === static::$app) {
            static::$app = new static($config);
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
        $classRouteManager = $this->config['routes']['class'] ?? null;
        $rules = $this->config['routes']['rules'] ?? [];

        if (!$classRouteManager) {
            $this->config['routes']['class'] = $classRouteManager = $this->defaultRouteManager;
        }

        try {
            $this->routeManager = new $classRouteManager($rules);
        } catch (\Throwable $e) {
            $this->routeManager = new $this->defaultRouteManager($rules);
        }

        $this->routeManager->init();
        $this->routeManager->mapping();
    }
}