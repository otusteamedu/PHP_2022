<?php

echo 'Сервер: '.$_SERVER['HOSTNAME'];

if (ini_get('session.save_handler') === 'memcached') {
    $memcache = new Memcached();
    $memcache->addServer('memcached', 11211);

    $prefix = ini_get('memcached.sess_prefix');

    var_dump($memcache->get($prefix . session_id()));
}

// Проверка запроса из первого пункта ДЗ
require "check_scopes.php";
