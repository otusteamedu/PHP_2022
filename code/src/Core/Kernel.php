<?php
declare(strict_types=1);


namespace Decole\Hw13\Core;


use Dotenv\Dotenv;
use Klein\Klein;

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
        $env->required(['STORAGE']);
    }
}