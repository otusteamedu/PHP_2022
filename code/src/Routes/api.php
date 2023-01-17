<?php

use Decole\Hw13\Controllers\EventController;

/**
 * see routing lib: https://github.com/klein/klein.php
 *
 * ['GET', '/posts', $callback],
 * ['POST', '/posts', $callback],
 * ['PUT', '/posts/[i:id]', $callback],
 * ['DELETE', '/posts/[i:id]', $callback],
 * ['OPTIONS', null, $callback],
 */
return [
    ['GET', '/', function ($request, $response) {(new EventController())->index($response);}],
    ['POST', '/event/add', function ($request, $response) {(new EventController())->add($request, $response);}],
    ['POST', '/events/find', function ($request, $response) {(new EventController())->find($request, $response);}],
    ['GET', '/events/flush', function ($request, $response) {(new EventController())->flush($response);}],
];