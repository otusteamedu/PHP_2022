<?php

declare(strict_types=1);

namespace Eliasjump\HwStoragePatterns\App\Kernel;

final class Router
{
    protected array $routes = [];

    private Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    public function get($path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            http_response_code(404);
            return "404 Not Found";
        }

        if (is_callable($callback)) {
            return call_user_func($callback);
        }

        if (class_exists($callback[0]) && method_exists($callback[0], $callback[1])) {
            return (new $callback[0]())->{$callback[1]}();
        }

        http_response_code(500);
        return "500 Bad request";
    }
}
