<?php

use FastRoute\RouteCollector;
use Nka\Otus\Modules\BracketsValidator\Controllers\BracketGetController;
use Nka\Otus\Modules\BracketsValidator\Controllers\BracketPostController;
use Nka\Otus\Modules\EmailValidator\Controllers\EmailGetController;
use Nka\Otus\Modules\EmailValidator\Controllers\EmailPostController;

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