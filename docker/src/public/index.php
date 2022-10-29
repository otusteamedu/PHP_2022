<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $redis = new Redis();
    $redis->connect('redis');
    $answerFromRedis = $redis->ping('Connection to Redis success<br>');
    $response->getBody()->write($answerFromRedis);

    $mc = new Memcached();
    $mc->addServer('memcached', 11211);
    $mc->set('Memcached', 'Connection to Memcached success<br>');
    $answerFromMemcached = $mc->get('Memcached');
    $response->getBody()->write($answerFromMemcached);

    return $response;
});

$app->run();