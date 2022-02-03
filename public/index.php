<?php
include 'vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$params = $dotenv->load();

$memcached = new \Clickalicious\Memcached\Client($params['MEMCACHED_HOST']);
$memcached->set('foo', 1.00);
$memcachedResponse = $memcached->get('foo');

if ($memcachedResponse == 1) {
    echo 'memcached is work! <br>' ;
}

$single_server = [
    'host' => $params['REDIS_HOST'],
    'port' => $params['REDIS_PORT'],
    'database' => $params['REDIS_DB'],
];

$redis = new \Predis\Client($single_server);
$redis->set('library', 'predis');
$redisResponse = $redis->get('library');

if ($redisResponse == 'predis') {
    echo 'redis is work! <br>';
}

$servername = $params['DB_HOST'];
$username = $params['DB_USERNAME'];
$password = $params['DB_PASSWORD'];

$mysql = new mysqli($servername, $username, $password);

if (!$mysql->connect_error) {
    echo "mysql is work! <br>";
} else {
    die("Connection failed: " . $mysql->connect_error);
}

?>

<br>
<h1>Курс PhP Professional</h1>
<br>
<h3>Галочкин Сергей</h3>
