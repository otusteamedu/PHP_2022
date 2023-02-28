<?php

use Nemizar\Php2022\Components\Router;
use Nemizar\Php2022\Controllers\IndexController;
use Nemizar\Php2022\Controllers\ValidateController;

Router::get('/', [IndexController::class, 'index']);

Router::post('/', [ValidateController::class, 'validate']);
