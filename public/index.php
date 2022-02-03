<?php
include 'vendor/autoload.php';

$memcached = new \Clickalicious\Memcached\Client('memcached');
$memcached->set('foo', 1.00);
$memcachedResponse = $memcached->get('foo');

if ($memcachedResponse == 1) {
    echo 'memcached is work! <br>' ;
}

$single_server = [
    'host' => 'redis',
    'port' => 6379,
    'database' => 0,
];

$redis = new \Predis\Client($single_server);
$redis->set('library', 'predis');
$redisResponse = $redis->get('library');

if ($redisResponse == 'predis') {
    echo 'redis is work! <br>';
}

$servername = "db";
$username = "root";
$password = "nZ2JUNFqDNwapMe3";

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
