<?php

declare(strict_types=1);

app()->get('/', function () {
    response()->page(viewsPath('index.html', false));
});

app()->get('/home', 'TestsController@index');

app()->get('/test', 'TestsController@test');

app()->get(pattern: '/api-doc', handler: function () {
    try {
        $openapi = \OpenApi\Generator::scan([__DIR__ . '/../controllers']);
        header('Content-Type: application/json');
        file_put_contents(filename: __DIR__ . '/../pages/openapi.json', data: $openapi->toJson());

        echo "Success";
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
});
