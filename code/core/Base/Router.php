<?php

namespace Core\Base;

use App\Application;

class Router
{
    /**
     * @throws \Core\Exceptions\InvalidArgumentException
     */
    public function init(): int
    {
        $defaultController = Application::$app->getRequest()->hasQueryString() ? null : Application::$app->get('baseController');
        $controllerNamespace = Application::$app->getRequest()->getControllerNamespace($defaultController);
        $controllerNamespace = Application::$app->get('controllersNamespace') . $controllerNamespace . 'Controller';

        if(class_exists($controllerNamespace)){
            $controller = new $controllerNamespace();
            $controller->runAction(Application::$app->getRequest()->getControllerAction($defaultController));
        }else{
            $this->errorActionLaunch();
        }

        return 1;
    }

    /**
     * @return void
     * @throws \Core\Exceptions\InvalidArgumentException
     */
    protected function errorActionLaunch()
    {
        $arr = explode('/', ltrim(Application::$app->get('errorAction'), "/"));
        $controller = "App\\Controllers\\".ucfirst($arr[0])."Controller";
        $action = ucfirst($arr[1]);
        $controller = new $controller;
        $controller->runAction($action);
    }
}