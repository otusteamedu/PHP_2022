<?php

use FastRoute\RouteCollector;
use hw4\modules\brackets_validator\controllers\BracketGetController;
use hw4\modules\brackets_validator\controllers\BracketPostController;

/**
 * @var RouteCollector $r
 */

$r->get('/', BracketGetController::class);
$r->post('/', BracketPostController::class);