<?php

declare(strict_types=1);

namespace App\App\Middleware;

use App\App\Event\Event;
use App\App\Event\EventStorageInterface;
use App\Infrastructure\Http\Response;
use Faker\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TestServicesMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EventStorageInterface $eventStorage
    )
    {
        $faker = Factory::create();
        dd((new \DateTimeImmutable())->sub(new \DateInterval('P1Y'))->format('m/y'));
        function numbersConcat(int ...$numbers): string {
            $str = '';
            $length = \count($numbers);
            for ($i = 0; $i < $length; $i++) {
                if ($i === 0) {
                    $str .= $numbers[$i];
                    continue;
                }

                if ($numbers[$i] === $numbers[$i - 1] + 1) {
                    if (\substr($str, -1) !== '-') {
                        $str .= '-';
                    }
                    if ($i === $length - 1) {
                        $str .= $numbers[$i];
                    }
                    continue;
                }

                $offset = -1;
                // Для отрицательных чисел нужно сравнивать два последних символа в строке т.к. есть знак "-"
                if ($numbers[$i - 1] < 0) {
                    $offset = -2;
                }
                if (\substr($str, $offset) !== (string)$numbers[$i - 1]) {
                    $str .= $numbers[$i - 1];
                }
                $str .= ',' . $numbers[$i];
            }

            return $str;
        }

        $cases = [
            // вариант из дз
            // корректный вывод 1-3,5,7-10
//    [1, 2, 3, 5, 7, 8, 9, 10],
            // добавляем отрицательные значения и 0
            // корректный вывод -10--8,-4,0,2-3,5,7-10
            [-10, -9, -8, -4, 0, 2, 3, 5, 7, 8, 9, 10],
            // без интервалов
            // корректный вывод -9,-7,-5,-2,0,2,5,7,10
//    [-9, -7, -5, -2, 0, 2, 5, 7, 10],
            // один сплошной интервал
            // корректный вывод -10-7
//    [-10, -9, -8, -7, -6, -5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5, 6, 7]
        ];

        foreach ($cases as $case) {
            echo numbersConcat(...$case) . PHP_EOL;
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Пример использования хранилища событий
        $this->eventStorage->deleteAll();
        $event1 = new Event(1000, 'event1', ['param1' => 1]);
        $event2 = new Event(2000, 'event2', ['param1' => 2, 'param2' => 2]);
        $event3 = new Event(3000, 'event3', ['param1' => 1, 'param2' => 2]);

        $this->eventStorage->add($event1);
        $this->eventStorage->add($event2);
        $this->eventStorage->add($event3);

        $res = $this->eventStorage->findMostAppropriateEventByCondition(['param1' => 1, 'param2' => 2]);

        echo '<pre>';
        print_r($res);
        echo '</pre>';

// Выведет:
//
//App\App\Event\Event Object
//(
//    [priority] => 3000
//    [event] => event3
//    [conditions] => Array
//        (
//            [param1] => 1
//            [param2] => 2
//        )
//
//)

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