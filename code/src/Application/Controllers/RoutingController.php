<?php

namespace Otus\App\Application\Controllers;

use Otus\App\Application\Viewer\View;

/**
 * Router
 */
class RoutingController
{
    protected static $routes = [];

    /**
     * @return void
     */
    public function index()
    {
        $controller_name = "Otus\\App\\Application\\Controllers\\IndexController";
        $action_name = "index";

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        if (array_key_exists($path, self::$routes)) {
            $controller = self::$routes[$path][0];
            $controller_name = "Otus\\App\\Application\\Controllers\\{$controller}Controller";
            $action_name = self::$routes[$path][1];
        } else {
            if ($path !== "") {
                @list($controller, $action) = explode("/", $path, 2);
                if (isset($controller)) {
                    $controller_name = "Otus\\App\\Application\\Controllers\\{$controller}Controller";
                }
                if (isset($action)) {
                    $action_name = $action;
                }
            }
        }

        // Check controller exists.
        if (!class_exists($controller_name, true)) {
            View::render('error', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
        }

        // redirect to 404
        if (!method_exists($controller_name, $action_name)) {
            View::render('error', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
        }

        $controller = new $controller_name();
        $controller->$action_name();
    }
}
