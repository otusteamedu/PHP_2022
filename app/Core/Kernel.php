<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Mechanisms\Configurator;

final class Kernel
{
    /**
     * @var array
     */
    private static array $instances = [];

    /**
     * construct
     */
    protected function __construct() {}

    /**
     * @return void
     */
    protected function __clone() {}

    /**
     * @return mixed
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception(message: "Cannot unserialize a singleton.");
    }

    /**
     * @return Kernel
     */
    public static function getInstance(): Kernel
    {
        $class = Kernel::class;

        if (! isset(self::$instances[$class])) {
            self::$instances[$class] = new Kernel();
        }

        return self::$instances[$class];
    }

    /**
     * @return void
     */
    public function initializeCliApplication(): void
    {
        $configurator = Configurator::getInstance();
        $configurator->createConfig();
    }
}
