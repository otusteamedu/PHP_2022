<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Nka\Otus\Components\Checker\CheckerService;
use Nka\Otus\Core\App;
use Nka\Otus\Core\Http\Request;
use Nka\Otus\Core\Http\RequestHandler;
use Nka\Otus\Core\Http\Response;
use Nka\Otus\Modules\BracketsValidator\Components\CorrectBracketChecker;
use Nka\Otus\Modules\BracketsValidator\Controllers\BracketGetController;
use Nka\Otus\Modules\BracketsValidator\Controllers\BracketPostController;
use Nka\Otus\Modules\EmailValidator\Components\CorrectEmailChecker;
use Nka\Otus\Modules\EmailValidator\Controllers\EmailGetController;
use Nka\Otus\Modules\EmailValidator\Controllers\EmailPostController;
use function DI\create;
use function DI\get;
use function FastRoute\simpleDispatcher;

$config = include "config.php";

return [
    'app' => create(App::class)
        ->constructor(
            get(Response::class),
            get(RequestHandler::class),
            $config
        ),
    RequestHandler::class => create(RequestHandler::class)
        ->constructor(
            get(Dispatcher::class),
            get(Request::class)
        ),
    Dispatcher::class => function () {
        return simpleDispatcher(fn(RouteCollector $r) => include "routes.php");
    },
    BracketGetController::class => create(BracketGetController::class),
    BracketPostController::class => create(BracketPostController::class)
        ->constructor(
            get(Request::class),
            create(CheckerService::class)
                ->constructor(get(CorrectBracketChecker::class))
        ),
    EmailGetController::class => create(EmailGetController::class),
    EmailPostController::class => create(EmailPostController::class)
        ->constructor(
            get(Request::class),
            create(CheckerService::class)
                ->constructor(get(CorrectEmailChecker::class))
        ),
];