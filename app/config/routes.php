<?php

use Nemizar\Php2022\Components\Router;
use Nemizar\Php2022\Controllers\ValidateController;

Router::get('/', static function () {
    require_once '../view/view.php';
});

Router::post('/', [ValidateController::class, 'validate']);
