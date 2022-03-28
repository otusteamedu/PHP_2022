<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use hw4\core\App;
use hw4\core\Request;
use hw4\core\RequestHandler;
use hw4\core\Response;
use hw4\modules\brackets_validator\components\CorrectBracketChecker;
use hw4\modules\brackets_validator\controllers\BracketGetController;
use hw4\modules\brackets_validator\controllers\BracketPostController;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

$config = include "config.php";

return [
    'app' => create(App::class)
        ->constructor(
            get(Request::class),
            get(Response::class),
            get(RequestHandler::class),
            $config
        ),

    RequestHandler::class => create(RequestHandler::class)
        ->constructor(
            get(Dispatcher::class),
            get(Request::class)
        ),
    Request::class => create(Request::class),
    Dispatcher::class => function () {
        return simpleDispatcher(fn(RouteCollector $r) => include "routes.php");
    },
    BracketGetController::class => create(BracketGetController::class),
    BracketPostController::class => create(BracketPostController::class)
        ->constructor(
            get(Request::class),
            get(CorrectBracketChecker::class)
        ),
];