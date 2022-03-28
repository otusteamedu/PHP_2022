<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use nka\otus\core\App;
use nka\otus\core\Request;
use nka\otus\core\RequestHandler;
use nka\otus\core\Response;
use nka\otus\modules\brackets_validator\components\CorrectBracketChecker;
use nka\otus\modules\brackets_validator\controllers\BracketGetController;
use nka\otus\modules\brackets_validator\controllers\BracketPostController;
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