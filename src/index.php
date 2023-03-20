<?php

declare(strict_types=1);

try {
    $memcache = new Memcache();
    $memcache->addServer('memcached');
    echo 'Memcache version ' . $memcache->getVersion() . PHP_EOL;
} catch (\Throwable $throwable) {
    echo 'Ошибка подключения Memcache: ' . $throwable->getMessage();
}

try {
    $redis = new Redis();
    $redis->connect('redis');
    echo '<br>Redis is connection ' . print_r($redis->isConnected(), true) . PHP_EOL;
} catch (\Throwable $throwable) {
    echo 'Ошибка подключения Redis : ' . $throwable->getMessage();
}

try {
    $dsn = 'pgsql:host=postgres;port=5432;dbname=PG_DATABASE;';
    $psql = new PDO($dsn, 'PG_USERNAME', 'PG_PASSWORD');
    echo '<br>PSQL is connection';
} catch (\Throwable $throwable) {
    echo 'Ошибка подключения PSQL: ' . $throwable->getMessage();
}
