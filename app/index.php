<?php

echo '<pre>';

echo 'OTUS: HW 1!' . PHP_EOL;

$memcache = new Memcached();
$memcache->addServer('memcached', 11211);
$memcache->set('testKey', 'value1');

echo 'value from memcache: ' . $memcache->get('testKey') . PHP_EOL;

echo '</pre>';

phpinfo();