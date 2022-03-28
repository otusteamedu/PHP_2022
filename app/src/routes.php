<?php

use FastRoute\RouteCollector;
use nka\otus\modules\brackets_validator\controllers\BracketGetController;
use nka\otus\modules\brackets_validator\controllers\BracketPostController;
use nka\otus\modules\email_validator\controllers\EmailGetController;
use nka\otus\modules\email_validator\controllers\EmailPostController;

/**
 * @var RouteCollector $r
 */


/**
 * Индекс делаем на проверку email
 * Прошлую домашку пихаем в подмодуль brackets
 */
$r->get('/', EmailGetController::class);
$r->post('/', EmailPostController::class);

$r->addGroup('/brackets', function (RouteCollector $r) {
    $r->get('/', BracketGetController::class);
    $r->post('/', BracketPostController::class);
});