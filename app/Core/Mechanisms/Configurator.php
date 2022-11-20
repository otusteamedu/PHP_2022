<?php

declare(strict_types=1);

namespace App\Core\Mechanisms;

final class Configurator
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
     * @return Configurator
     */
    public static function getInstance(): Configurator
    {
        $cls = Configurator::class;

        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new Configurator();
        }

        return self::$instances[$cls];
    }

    /**
     * @return void
     */
    public function createConfig(): void
    {
        $common_config = include(__DIR__ . '/../../config/common.php');

        $general_config = array_merge([], $common_config);

        foreach ($general_config as $key => $value) {
            $_ENV[strtoupper(string: $key)] = $value;
        }
    }
}
