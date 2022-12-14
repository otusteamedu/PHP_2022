<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Viewer\View;


class App
{
//TODO удалить про Linux
    protected static $routes = [];

    public static function run()
    {
        $controller_name = "Otus\\App\\Controllers\\IndexController";
        $action_name = "index";

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        if(array_key_exists($path,self::$routes))
        {
            $controller = self::$routes[$path][0];
            $controller_name = "Otus\\App\\Controllers\\{$controller}Controller";
            $action_name = self::$routes[$path][1];
        } else {
            if($path !== "")
            {
                @list($controller, $action) = explode("/", $path, 2);
                if (isset($controller)){
                    $controller_name = "Otus\\App\\Controllers\\{$controller}Controller";
                }
                if (isset($action)){
                    $action_name = $action;
                }
            }
        }

        // Check controller exists.
        if(!class_exists($controller_name,true)) {
            //redirect to 404
            View::render('404');
        }

        if(!method_exists($controller_name, $action_name)) {
            //redirect to 404
            View::render('404');
        }

        $controller = new $controller_name();
        $controller->$action_name();
    }

    public static function getConfig()
    {
        if (!file_exists('/data/mysite.local/src/Config/config.php')) {
            return false;
        } else {
            return include('Config/config.php');
        }
    }

}
