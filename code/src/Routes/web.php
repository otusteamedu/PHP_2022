<?php

use Decole\Hw18\Application\Http\AppController;

return [
    ['GET', '/', function ($request, $response) {(new AppController())->index($request, $response);}],
    ['POST', '/create', function ($request, $response) {(new AppController())->create($request, $response);}],
];