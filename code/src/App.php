<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\Application\Viewer\View;

/**
 * Main app class
 */
class App
{
    protected static $routes = [];

    /**
     * Runnng app
     * @return void
     */
    public static function run()
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

    /**
     * Read rammitmq config
     * @return false|mixed
     */
    public static function getConfig(): array
    {
        if (!file_exists('/data/mysite.local/src/Config/config.php')) {
            return false;
        } else {
            return include('Config/config.php');
        }
    }

    /**
     * Read mailing config
     * @return false|mixed
     */
    public static function getMailConfig(): array
    {
        if (!file_exists('/data/mysite.local/src/Config/config_mail.php')) {
            return false;
        } else {
            return include('Config/config_mail.php');
        }
    }
}
