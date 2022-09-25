<?php

declare(strict_types=1);

namespace App\SearchEngine\Mechanisms;

final class Configuration
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
     * @return Configuration
     */
    public static function getInstance(): Configuration
    {
        $cls = Configuration::class;

        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new Configuration();
        }

        return self::$instances[$cls];
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        $env_configuration = array_filter(
            array: getenv(),
            callback: function ($env_param_value, $env_param_name) {
                return in_array(needle: $env_param_name, haystack: ['ELASTIC_PASSWORD']);
            },
            mode: ARRAY_FILTER_USE_BOTH
        );

        $ini_params = parse_ini_file(filename: __DIR__ . '/../config/elasticsearch.ini');

        /**
         * регистр ключей в массиве не подвергается изменению ради консистентности имен в конфиг-файлах и в коде
         */
        return array_merge($ini_params, $env_configuration);
    }
}
