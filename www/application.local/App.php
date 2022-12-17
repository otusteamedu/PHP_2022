<?php

namespace app;

use app\components\Error;
use app\components\Request;

class App {
    public $route;
    private string $controller;
    private string $action;

    public function __construct() {
        $this->route = Request::get('route');
    }

    public function run(): string {
        try {
            $this->setAction();
            return (new $this->controller)->{$this->action}();
        } catch (\Throwable $e) {
            return (new Error())->show($e->getMessage(), $e->getCode());
        }
    }

    private function setAction() {
        if (!$this->route){
            throw new \Exception('Не указан route.', 400);
        }
        $routeArr = explode('/', $this->route);
        if (count($routeArr) !== 2) {
            throw new \Exception('Неправильный route.', 400);
        }

        $this->controller = 'app\\controllers\\'.ucfirst(strtolower($routeArr[0])).'Controller';
        $this->action = 'action'.ucfirst(strtolower($routeArr[1]));
        if (!class_exists($this->controller) || !method_exists($this->controller, $this->action)) {
            throw new \Exception('Такого действия не существует.', 400);
        }

    }
}
