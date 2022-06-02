<?php

use Decole\Hw18\Application\Http\AppController;

return [
    ['GET', '/', function ($request, $response, $service) use ($container) {(new AppController())->index($request, $response, $service, $container);}],
    ['POST', '/create', function ($request, $response, $service) use ($container) {(new AppController())->create($request, $response, $service, $container);}],
];