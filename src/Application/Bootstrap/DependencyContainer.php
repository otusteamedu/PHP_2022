<?php

declare(strict_types=1);

namespace Src\Application\Bootstrap;

use DI\{Container, ContainerBuilder, DependencyException, NotFoundException};

final class DependencyContainer
{
    private const PATH_TO_DEPENDENCY_INJECTION_DEFINITIONS_FILE =
        '/../config_files/dependency_injection_definitions.php';

    /**
     * @var array
     */
    private static array $instances = [];

    /**
     * construct
     */
    protected function __construct()
    {
        //
    }

    /**
     * @return void
     */
    protected function __clone()
    {
        //
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception(message: "Cannot unserialize a singleton.");
    }

    /**
     * @return DependencyContainer
     */
    public static function getInstance(): DependencyContainer
    {
        $cls = self::class;

        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new DependencyContainer();
        }

        return self::$instances[$cls];
    }

    /**
     * @return Container
     * @throws \Exception
     */
    public function initializeDependencies(): Container
    {
        $container = new ContainerBuilder();

        $container->addDefinitions(__DIR__ . self::PATH_TO_DEPENDENCY_INJECTION_DEFINITIONS_FILE)
            ->useAutowiring(bool: true);

        return $container->build();
    }

    /**
     * @param string $dependency
     * @return mixed
     * @throws DependencyException
     * @throws NotFoundException
     * @throws \Exception
     */
    public function make(string $dependency): mixed
    {
        $container = self::getInstance()->initializeDependencies();

        return $container->get($dependency);
    }
}
