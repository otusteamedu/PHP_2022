<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Application\Viewer\View;


class App
{
    protected static $routes = [];

    public static function run()
    {
        $controller_name = "Otus\\App\\Application\\Controllers\\IndexController";
        $action_name = "index";

        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        if(array_key_exists($path,self::$routes))
        {
            $controller = self::$routes[$path][0];
            $controller_name = "Otus\\App\\Application\\Controllers\\{$controller}Controller";
            $action_name = self::$routes[$path][1];
        } else {
            if($path !== "")
            {
                @list($controller, $action) = explode("/", $path, 2);
                if (isset($controller)){
                    $controller_name = "Otus\\App\\Application\\Controllers\\{$controller}Controller";
                }
                if (isset($action)){
                    $action_name = $action;
                }
            }
        }

        // Check controller exists.
        if(!class_exists($controller_name,true)) {
            //redirect to 404
            View::render('error', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
        }

        if(!method_exists($controller_name, $action_name)) {
            //redirect to 404
            View::render('error', [
                'title' => 'Ошибка 404',
                'error_code' => '404 - Not Found',
                'result' => 'Нет такой страницы'
            ]);
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

    public static function getMailConfig()
    {
        if (!file_exists('/data/mysite.local/src/Config/config_mail.php')) {
            return false;
        } else {
            return include('Config/config_mail.php');
        }
    }
}
