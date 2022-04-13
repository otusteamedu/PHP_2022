<?php

use Decole\Hw13\Controllers\EventController;

return [
    ['GET', '/', function ($request, $response, $service) {(new EventController())->index($request, $response, $service);}],
];