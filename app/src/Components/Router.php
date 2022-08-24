<?php

declare(strict_types=1);

namespace Nemizar\Php2022\Components;

class Router
{
    private static array $handlers;

    private static function loadRoutes(): void
    {
        require_once './../config/routes.php';
    }

    public static function get(string $path, $handler): void
    {
        self::addHandler('GET', $path, $handler);
    }

    public static function post(string $path, $handler): void
    {
        self::addHandler('POST', $path, $handler);
    }

    private static function addHandler(string $method, string $path, $handler): void
    {
        self::$handlers[$method . $path] = [
            'path'    => $path,
            'method'  => $method,
            'handler' => $handler,
        ];
    }

    public static function run(): void
    {
        self::loadRoutes();
        $requestUri = \parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        foreach (self::$handlers as $handler) {
            if ($handler['method'] === $method && $handler['path'] === $requestPath) {
                $callback = $handler['handler'];
            }
        }

        if (!$callback) {
            \header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            return;
        }

        $params = \array_merge($_GET, $_POST);
        if (\is_array($callback)) {
            [$className, $method] = $callback;
            (new $className())->$method($params);
        } else {
            \call_user_func($callback, $params);
        }
    }
}
