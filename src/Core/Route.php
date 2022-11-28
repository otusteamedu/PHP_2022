<?php

namespace Dmitry\App\Core;

class Route
{

    /**
     * @var Route[] $routes
     */
    private static array $routes = [];

    private string $url;

    private string $method;

    private array $handler;

    private function __construct(string $url, string $method, array $handler)
    {
        $this->url = $url;
        $this->method = $method;
        $this->handler = $handler;
    }

    public function __invoke(Request $request): Response
    {
        return call_user_func_array([new $this->handler[0], $this->handler[1]], [$request]);
    }

    public static function post(string $url, array $handler): void
    {
        self::$routes[] = new Route($url, 'POST', $handler);
    }

    public static function get(string $url, array $handler): void
    {
        self::$routes[] = new Route($url, 'GET', $handler);
    }

    public static function find(Request $request): ?Route
    {
        foreach (self::$routes as $route) {
            if ($request->method() !== $route->method) {
                continue;
            }

            if ($request->url() === $route->url) {
                return $route;
            }
        }

        return null;
    }
}