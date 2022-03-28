<?php

use FastRoute\RouteCollector;
use nka\otus\modules\brackets_validator\controllers\BracketGetController;
use nka\otus\modules\brackets_validator\controllers\BracketPostController;

/**
 * @var RouteCollector $r
 */

$r->get('/', BracketGetController::class);
$r->post('/', BracketPostController::class);