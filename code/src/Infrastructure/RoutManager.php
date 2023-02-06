<?php


namespace Study\Cinema\Infrastructure;

use Study\Cinema\Infrastructure\View\View;

class RoutManager
{
    const ALLOWED_ACTIONS = ['index', 'get', 'delete'];
    const ALLOWED_ROUTES = ['statement',''];
    const NAMESPACE = "Study\\Cinema\\Infrastructure\\Controller\\";
    public function __construct()
    {
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $routes = explode('/', $url);


        if (empty($routes[1] && in_array(strtolower($routes[1]),self::ALLOWED_ROUTES)) ) {
            View::render('error/404', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
        }
        else{
            $route = ucfirst(strtolower($routes[1]));
            $controller_name = self::NAMESPACE."{$route}Controller";

        }


        if (empty($routes[2] && in_array(strtolower($routes[2]),self::ALLOWED_ACTIONS)) ) {
            View::render('error/404', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
           // throw new RoutingException("Действие не определено");
        }
        $action_name = strtolower($routes[2]);

        // redirect to 404
        if (!class_exists($controller_name, true)) {
            View::render('error/404', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);

            //throw new RoutingException("Действие не реализовано.");
        }

        // redirect to 404
        if(!method_exists($controller_name, $action_name)) {
            View::render('error/404', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
          //throw new RoutingException("Действие не реализовано.");
        }

        $controller = new $controller_name();
        $controller->$action_name();


    }

}