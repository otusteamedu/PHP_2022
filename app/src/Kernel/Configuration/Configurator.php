<?php

declare(strict_types=1);

namespace App\Src\Kernel\Configuration;

use App\Src\Repositories\Contracts\Repository;

final class Configurator
{
    private const NAMESPACE_REPOSITORY = '\App\Src\Repositories\\';

    /**
     * @var array
     */
    private static array $instances = [];

    /**
     * construct
     */
    protected function __construct()
    {
    }

    /**
     * @return void
     */
    protected function __clone()
    {
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
     * @return Configurator
     */
    public static function getInstance(): Configurator
    {
        $cls = Configurator::class;

        if (!isset(self::$instances[$cls])) {
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

    /**
     * @return Repository
     */
    public function getRepository(): Repository
    {
        $repository_class_name =
            self::NAMESPACE_REPOSITORY . $_ENV['REPOSITORY'] . '\\' . $_ENV['REPOSITORY'] . 'Repository';

        return new $repository_class_name();
    }
}
