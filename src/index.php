<?php

session_start();
$_SESSION['connected'] = time();

if (!isset($_SESSION['first_visit'])) {
    $_SESSION['first_visit'] = time();
}

echo 'Сервер: '.$_SERVER['HOSTNAME'].'<br/>';

if (ini_get('session.save_handler') === 'memcached') {
    $memcache = new Memcached();
    $memcache->addServer('memcached', 11211);

    $prefix = ini_get('memcached.sess_prefix');

    $memcacheSession = $prefix.session_id();

    echo 'Первый визит: '.$_SESSION['first_visit'].'<br/>';
    echo 'Последний визит: '.$_SESSION['connected'].'<br/>';
    echo 'Сессия: '.$memcacheSession.'<br/>';
}

// Проверка запроса из первого пункта ДЗ
require "check_scopes.php";
