<?php
declare(strict_types=1);


namespace Decole\Hw15\Core;


use Dotenv\Dotenv;
use Klein\Klein;
use PDO;
use PDOException;

final class Kernel
{
    private Klein $router;

    private array $rotes = [];

    public function __construct()
    {
        $this->routes();
        $this->loadEnv();
    }

    public function run(): void
    {
        $this->router->dispatch();
    }

    public static function getConfigParam(string $param): ?string
    {
        return $_ENV[$param];
    }

    public static function dump(mixed $value): void
    {
        var_dump($value);
        exit();
    }

    public static function connect(): PDO
    {
        try {
            $host = self::getConfigParam('DB_HOST');
            $port = self::getConfigParam('DB_PORT');
            $db = self::getConfigParam('DB_DATABASE');
            $user = self::getConfigParam('DB_USERNAME');
            $password = self::getConfigParam('DB_PASSWORD');

            $dsn = "pgsql:host=$host;port=$port;dbname=$db;";

            return new PDO(
                $dsn,
                $user,
                $password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function routes(): void
    {
        $this->router = new Klein();

        $api = require(__DIR__ . '/../Routes/api.php');

        foreach ($api as $route) {
            $this->router->respond(...$route);
        }
    }

    private function loadEnv(): void
    {
        $env = Dotenv::createImmutable(__DIR__ . '/../../');
        $env->load();
        $env->required([
            'DB_USERNAME',
            'DB_PASSWORD',
            'DB_DATABASE',
            'DB_CONNECTION',
            'DB_HOST',
        ]);
    }
}