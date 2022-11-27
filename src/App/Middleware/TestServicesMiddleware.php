<?php

declare(strict_types=1);

namespace App\App\Middleware;

use App\Infrastructure\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestServicesMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUri()->getPath() === '/test') {
            return new Response($this->getResponseContent(), 200);
        }

        return $handler->handle($request);
    }

    private function getResponseContent()
    {
        $content = '<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello page</title>
</head>
<body>
    <h2>Hi, user!</h2>';

        $content .= '<p>PHP works</p>';
        $content .= '<p>Кириллица выводится корректно</p>';
        $content .= '<p>Тест БД</p>';

        // проверка подключения к БД
        $dsn = 'pgsql:dbname=app;host=db';
        $user = 'app';
        $password = 'app';

        $dbh = new \PDO($dsn, $user, $password);
        $x = $dbh->query('SELECT datname FROM pg_database;')->fetchAll();
        $content .= '<pre>';
        $content .= var_export($x, true);
        $content .= '</pre>';

        // проверка подключения к Redis
        $redis = new \Redis();
        $redis->connect('redis');
        $content .= '<p>Redis сервер работает: ' . $redis->ping() . '</p>';

        $memcache = new \Memcache();
        $memcache->connect('memcache', 11211) or die ('Не удается подключиться к Memcache');
        $version = $memcache->getVersion();
        $content .= "<p>Подключение к Memcache успешно. Версия " . $version . "</p>";
        $content .= '</body></html>';

        return $content;
    }
}