<?php

use Getinweb\TestComposerPackage\PrintProcessor;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $arr = [
        'level1' => [
            '1' => 1,
            'level2' => [
                '2' => 2,
                'level3' => 3,
            ],
        ]
    ];
    $formatted_output = PrintProcessor::print_array($arr);
    $response->getBody()->write($formatted_output);
    return $response;
});

$app->run();