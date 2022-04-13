<?php
declare(strict_types=1);


namespace Decole\Hw13\Core;


use Klein\Klein;

final class Kernel
{
    private Klein $router;

    private array $rotes = [];

    public function __construct()
    {
        $this->router = new Klein();
        $this->routes();
    }

    public function run(): void
    {
        $this->router->dispatch();
    }

    /**
     * $klein->respond('GET', '/posts', $callback);
     * $klein->respond('POST', '/posts', $callback);
     * $klein->respond('PUT', '/posts/[i:id]', $callback);
     * $klein->respond('DELETE', '/posts/[i:id]', $callback);
     * $klein->respond('OPTIONS', null, $callback);
     */
    private function routes(): void
    {

        $api = require(__DIR__ . '/../Routes/api.php');

        foreach ($api as $route) {
            $this->router->respond(...$route);
        }
    }
}