<?php

use Decole\Hw13\Controllers\EventController;

/**
 * ['GET', '/posts', $callback],
 * ['POST', '/posts', $callback],
 * ['PUT', '/posts/[i:id]', $callback],
 * ['DELETE', '/posts/[i:id]', $callback],
 * ['OPTIONS', null, $callback],
 */

return [
    ['GET', '/', function ($request, $response) {(new EventController())->index($request, $response);}],
    ['POST', '/event/add', function ($request, $response) {(new EventController())->add($request, $response);}],
];