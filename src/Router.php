<?php

namespace App;

use App\Controller\Main;
use App\Model\ConfigInterface;
use App\Model\SendMessageInterface;

class Router
{
    static function start(ConfigInterface $config, SendMessageInterface $messenger)
    {
        // контроллер и действие по умолчанию
        $action_name = 'startPage';

        // получаем имя контроллера
        if ( !empty($_GET['action']) )
        {
            switch($_GET['action'])
            {
                case 'startConsumers':
                    $action_name = 'consumerStart';
                    break;
                case 'stopConsumers':
                    $action_name = 'consumerStop';
                    break;
            }
        }
        else if ($_POST['action']=='make')
        {
            $action_name = 'startReportGenerator';
        }

        // создаем контроллер
        $controller = new Main($config, $messenger);

        if(method_exists($controller, $action_name))
        {
            $controller->$action_name();
        }
        else
        {
            Route::ErrorPage404();
        }

    }

    function ErrorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}