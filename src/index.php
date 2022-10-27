<?php

session_start();
$_SESSION['connected'] = time();

if (isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] += 1;
} else {
    $_SESSION['visit_count'] = 0;
}

if (ini_get('session.save_handler') === 'memcached') {
    $memcache = new Memcached();
    $memcache->addServer('memcached', 11211);

    $prefix = ini_get('memcached.sess_prefix');

    var_dump($memcache->get($prefix . session_id()));
}

if (ini_get('session.save_handler') === 'redis') {
    $redis = new Redis();
    $redis->connect('redis');

    if ($redis->isConnected()) {
        print_r($redis->get('PHPREDIS_SESSION:' . session_id()));
    }
}

$mysqli = mysqli_connect('db', 'root', 'root');
if ($mysqli->connect_error) {
    die($mysqli->connect_error);
}
var_dump($mysqli->client_info);
