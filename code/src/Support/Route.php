<?php

namespace Koptev\Support;

use Koptev\Exceptions\NotFoundException;

class Route
{
    private static array $get = [];
    private static array $post = [];

    /**
     * @param $uri
     * @param $action
     * @return void
     */
    public static function get($uri, $action)
    {
        self::$get[$uri] = $action;
    }

    /**
     * @param $uri
     * @param $action
     * @return void
     */
    public static function post($uri, $action)
    {
        self::$post[$uri] = $action;
    }

    /**
     * @return void
     */
    public static function load()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/../config/routes.php';
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotFoundException
     */
    public static function getAction(Request $request): array
    {
        $method = strtolower($request->method());
        $uri = $request->uri();

        if ($method === 'post' && isset(self::$post[$uri])) {
            return self::$post[$uri];
        }

        if ($method === 'get' && isset(self::$get[$uri])) {
            return self::$get[$uri];
        }

        throw new NotFoundException();
    }
}
