<?php

// Memcached
$memcacheD = new Memcached;
$memcacheD->addServer(getenv('MEMCACHED_HOST'), getenv('MEMCACHED_PORT'));
$memcacheD->set('random_num', rand());
echo sprintf('Memcached: %d', $memcacheD->get('random_num'));
echo '<br />';

//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT'));
$redis->set('random_num', rand());
echo sprintf('Redis: %d', $redis->get('random_num'));
echo '<br />';

//phpinfo();