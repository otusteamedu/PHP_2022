<?php

declare(strict_types=1);

namespace Src\Services;

final class Configuration
{
    private static array $instances = [];

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
        $socket_paths_files = parse_ini_file(filename: getcwd() . '/config/socket_files_paths.ini');

        return [
            'server_side_socket_file_path' => getcwd() . $socket_paths_files['server_side_socket_file_path'],
            'client_side_socket_file_path' => getcwd() . $socket_paths_files['client_side_socket_file_path'],
        ];
    }
}
