<?php

use hw4\components\CorrectBracketChecker;
use hw4\controllers\MainController;
use hw4\core\App;
use hw4\core\Request;
use hw4\core\Response;
use function DI\create;
use function DI\get;

$config = include "config.php";

return [
    'app' => create(App::class)
        ->constructor(
            get(MainController::class),
            get(Request::class),
            get(Response::class),
            $config
        ),
    MainController::class => create(MainController::class)
        ->constructor(
            get(Request::class),
            get(CorrectBracketChecker::class)
        ),
    Request::class => create(Request::class)
];