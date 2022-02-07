<?php

echo "Hello world" . PHP_EOL;

error_reporting(E_ALL & ~E_NOTICE);

$redis = new Redis();
if ($redis->connect('redis', 6379)) {
    echo "Redis is ready" . PHP_EOL;
}

$memcached = new Memcached;
$memcached->addServer('memcached', 11211);

var_dump($memcached->getServerList());
