<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {

    try {
        $dsn = 'pgsql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME') . ';port=' . getenv('DB_PORT') . ';';
        new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
        $response->getBody()->write('Successful database connection<br>');
    } catch (PDOException $e) {
        $response->getBody()->write('Error connecting to database: ');
        $response->getBody()->write($e->getMessage() . '<br>');
    }

    $redis = new Redis();
    try {
        $redis->connect('redis', getenv('REDIS_PORT'));
        $answerFromRedis = $redis->ping('Successful Redis connection<br>');
        $response->getBody()->write($answerFromRedis);
    } catch (RedisException $e) {
        $response->getBody()->write('Error connecting to Redis: ');
        $response->getBody()->write($e->getMessage() . '<br>');
    }

    $mc = new Memcached();
    try {
        $mc->addServer('memcached', getenv('MEMCACHED_PORT'));
        $mc->set('Memcached', 'Successful Memcached connection<br>');
        $answerFromMemcached = $mc->get('Memcached');
        $response->getBody()->write($answerFromMemcached);
    } catch (MemcachedException $e) {
        $response->getBody()->write('Error connecting to Memcached: ');
        $response->getBody()->write($e->getMessage());
    }

    return $response;
});

$app->run();