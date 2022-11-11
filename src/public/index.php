<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {

    $message = 'Hello from ' . $_SERVER['SERVER_NAME'] . '<br>';

    $response->getBody()->write($message);

    session_start();
    if (!isset($_SESSION['visit'])) {
        $message = "This is the first time you're visiting this server\n";
        $_SESSION['visit'] = 0;
    } else {
        $message = "Your number of visits: " . $_SESSION['visit'] . "\n";
    }


    $_SESSION['visit']++;

    $response->getBody()->write($message);
    return $response;
});

$app->run();