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
    $memcache->addServer('memcache', 11211);

    $prefix = ini_get('memcached.sess_prefix');

    var_dump($memcache->get($prefix . session_id()));
}
