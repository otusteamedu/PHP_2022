<?php


namespace Study\Cinema\Infrastructure;


use Study\Cinema\Infrastructure\Response\Response;

class RoutManager
{
    const ALLOWED_ACTIONS = ['index', 'get', 'delete', 'post'];
    const ALLOWED_ROUTES = ['request',''];
    const NAMESPACE = "Study\\Cinema\\Infrastructure\\Controller\\Api\\v1\\";
    public function __construct()
    {
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $routes = explode('/', $url);


        if (empty($routes[1]) || !in_array(strtolower($routes[1]),self::ALLOWED_ROUTES)) {
              Response::send(Response::HTTP_CODE_BAD_REQUEST, "Нет такой страницы" );

        }
        else{
            $route = ucfirst(strtolower($routes[1]));
            $controller_name = self::NAMESPACE."{$route}Controller";

        }
        if(empty($routes[2])) {
            $action_name = "index";
        }
        else if (!in_array(strtolower($routes[2]), self::ALLOWED_ACTIONS)) {
              Response::send(Response::HTTP_CODE_BAD_REQUEST, "Нет такой страницы" );
        }
        else {
            $action_name = strtolower($routes[2]);
        }


        if (!class_exists($controller_name, true)) {
              Response::send(Response::HTTP_CODE_BAD_REQUEST, "Нет такой страницы" );

       }
       if(!method_exists($controller_name, $action_name)) {
              Response::send(Response::HTTP_CODE_BAD_REQUEST, "Нет такой страницы" );

       }

        $controller = new $controller_name();
        $controller->$action_name();
    }

}