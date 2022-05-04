<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

$redis = new Redis();
$redis->connect('redis', 6379);
if ($redis->ping()) {
    echo "Redis connection OK<br>";
}

$memcache = new Memcache();
$memcacheConnectResult = $memcache->connect('memcached', 11211);
if ($memcacheConnectResult) {
    echo 'Memcached connection OK<br>';
    $version = $memcache->getVersion();
    echo "Версия сервера: ".$version."<br/>\n";
}

phpinfo();