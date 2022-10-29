<?php

$redis = new Redis();
$redis->connect('redis');
echo $redis->ping('Connection to redis success<br>');

$mc = new Memcached();
$mc->addServer('memcached', 11211);
$mc->set('Memcached', 'Connection to memcached success<br>');
echo $mc->get('Memcached');