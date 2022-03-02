<?php

namespace App;

use Core\Components\Request;

class Application
{
    /**
     * @var string $id
     * @var string $baseDir
     * @var string $controllersNamespace
     * @var string $baseController
     * @var string $errorAction
     */
    protected string $id;
    protected string $baseDir;
    protected string $controllersNamespace;
    protected string $baseController;
    protected string $errorAction;
    protected Request $request;

    public function __construct(array $config = [])
    {
        if (count($config) > 0) {
            foreach ($config as $key => $param) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $param;
                }
            }
        }

        $this->request = new Request();
    }

    /**
     * @return int
     */
    public function run() :int
    {
        $defaultController = $this->request->hasQueryString() ? null : $this->baseController;
        $controllerNamespace = $this->request->getControllerNamespace($defaultController);
        $controllerNamespace = $this->controllersNamespace . $controllerNamespace . 'Controller';

        if(class_exists($controllerNamespace)){
            $controller = new $controllerNamespace();
            $controller->runAction($this->request->getControllerAction($defaultController));
        }else{
            $this->errorActionLaunch();
        }

        return 1;
    }

    /**
     * @return void
     */
    protected function errorActionLaunch()
    {
        $arr = explode('/', ltrim($this->errorAction, "/"));
        $controller = "App\\Controllers\\".ucfirst($arr[0])."Controller";
        $action = ucfirst($arr[1]);
        $controller = new $controller;
        $controller->runAction($action);
    }
}